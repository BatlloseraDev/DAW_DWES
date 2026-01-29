// import './style.css';
import { io, Socket } from 'socket.io-client';

// --- CONFIGURACIÓN ---
const API_URL = 'http://localhost:9090/api/users';
const SOCKET_URL = 'http://localhost:9091';

// --- ESTADO DE LA APP ---
let currentUser: { id: number; name: string } | null = null;
let socket: Socket | null = null;
let currentGameId: number | null = null;

// --- REFERENCIAS AL DOM ---
const loginSection = document.getElementById('login-section')!;
const lobbySection = document.getElementById('lobby-section')!;
const gameSection = document.getElementById('game-section')!;

const emailInput = document.getElementById('email-input') as HTMLInputElement;
const passInput = document.getElementById('password-input') as HTMLInputElement;
const nameInput = document.getElementById('name-input') as HTMLInputElement;
const loginError = document.getElementById('login-error')!;

const btnLogin = document.getElementById('btn-login')!;
const btnRegister = document.getElementById('btn-register')!;
const btnCreateHuman = document.getElementById('btn-create-human')!;
const btnLeave = document.getElementById('btn-leave')!;
const btnRefreshRanking = document.getElementById('btn-refresh-ranking')!;
const btnCreateCpu = document.getElementById('btn-create-cpu')!;

const gamesList = document.getElementById('games-list')!;
const rankingList = document.getElementById('ranking-list')!;
const usernameDisplay = document.getElementById('username-display')!;

// Elementos del juego
const gameStatus = document.getElementById('game-status')!;
const roundInfo = document.getElementById('round-info')!;
const creatorText = document.getElementById('creator-text')!;
const opponentText = document.getElementById('opponent-text')!;
const myMoveDisplay = document.getElementById('my-move')!;
const oppMoveDisplay = document.getElementById('opponent-move')!;
const moveButtons = document.querySelectorAll('.btn-move');

// --- NAVEGACIÓN ---
function showSection(section: 'login' | 'lobby' | 'game') {
  loginSection.classList.add('hidden');
  lobbySection.classList.add('hidden');
  gameSection.classList.add('hidden');

  if (section === 'login') loginSection.classList.remove('hidden');
  if (section === 'lobby') lobbySection.classList.remove('hidden');
  if (section === 'game') gameSection.classList.remove('hidden');
}

// --- 1. LÓGICA HTTP (Login/Registro) ---

async function handleAuth(action: 'login' | 'register') {
  const email = emailInput.value;
  const password = passInput.value;
  const name = nameInput.value;

  try {
    const endpoint = action === 'login' ? '/login' : '/register';
    const body = action === 'register' ? { name, email, password } : { email, password };

    const response = await fetch(`${API_URL}${endpoint}`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(body),
    });

    const data = await response.json();

    if (!response.ok) throw new Error(data.error || 'Error en la petición');

    // Éxito
    currentUser = data.data;

    usernameDisplay.innerText = currentUser!.name;
    loginError.innerText = '';

    // Conectar WebSocket una vez logueado
    connectSocket();

    // Cargar ranking inicial
    fetchRanking();

    showSection('lobby');

  } catch (error: any) {
    console.log(error);
    loginError.innerText = error.message;
  }
}

async function fetchRanking() {
  try {
    const res = await fetch(`${API_URL}/ranking`);
    const ranking = await res.json();
    if (res.status == 404) {
      console.log("no hay partidas");
      return;
    }
    rankingList.innerHTML = '';
    ranking.forEach((user: any) => {
      const li = document.createElement('li');
      li.innerText = `${user.name} - WinRate: ${user.winRate}% (G: ${user.won} / T: ${user.played})`;
      rankingList.appendChild(li);
    });
  } catch (err) {
    console.error("Error cargando ranking", err);
  }
}

// --- 2. LÓGICA WEBSOCKETS ---

function connectSocket() {
  if (socket) return; // Ya conectado


  socket = io(SOCKET_URL, {
    extraHeaders: {
      // Aquí podría mandar token
      "user-id": currentUser!.id.toString()
    }
  });

  socket.on('connect', () => {
    console.log('⚡ Conectado al servidor WS');
  });

  // Evento: Lista de partidas disponibles
  socket.on('server:available_games', (games: any[]) => {
    renderGamesList(games);
  });

  // Evento: Partida creada exitosamente (soy el creador)
  socket.on('server:game_created', (data: { gameId: number, room: string }) => {
    console.log("Partida creada:", data);
    currentGameId = data.gameId;
    waitingForOpponentState();
    showSection('game');
  });

  // Evento: Partida iniciada (ambos jugadores listos)
  socket.on('server:game_started', (data: { gameId: number }) => {
    currentGameId = data.gameId;
    gameStatus.innerText = "¡JUEGO INICIADO! Haz tu jugada.";
    gameStatus.style.color = "lightgreen";
    resetBoard();
    showSection('game');
  });

  // Evento: Resultado de ronda
  socket.on('server:round_result', (data: any) => {
    // data: { winner: 'creator'|'opponent'|'draw', creator: 'rock', opponent: 'scissors', ... }

    // Mostrar qué sacó cada uno

    creatorText.innerText = `Creador`;//un poco "guarripage"
    opponentText.innerText = `Rival`;
    myMoveDisplay.innerText = data.creator === 'rock' ? '🪨' : data.creator === 'paper' ? '📄' : '✂️'; //en un futuro implementare lagarto y spock
    oppMoveDisplay.innerText = data.opponent === 'rock' ? '🪨' : data.opponent === 'paper' ? '📄' : '✂️';
    const result = data.winner.toUpperCase();
    gameStatus.innerText = `Resultado ronda: ${result=== 'DRAW' ? 'EMPATE' : result === 'CREATOR' ? 'CREADOR GANÓ' : 'RIVAL GANÓ'}`;
    //la verdad pensaba que iba a quedar mas bonita la linea de arriba
    roundInfo.innerText = `Ronda ${data.round + 1}`;
    // Limpiar tablero tras unos segundos para la siguiente ronda
    setTimeout(() => {
      gameStatus.innerText = "¡Siguiente Ronda! Tira otra vez.";
      resetBoard();
    }, 2000);
  });

  // Evento: Fin de juego
  socket.on('server:game_finished', (data: { winnerId: number, reason?: string }) => {
    const iWon = data.winnerId === currentUser!.id;
    if (iWon) {
      if (data.reason === 'opponent_left') {
        gameStatus.innerText = "🏆 ¡GANASTE! El rival abandonó la partida.";
      } else {
        gameStatus.innerText = "🏆 ¡GANASTE LA PARTIDA!";
      }
      gameStatus.style.color = "gold";
    } else {
      gameStatus.innerText = "💀 PERDISTE LA PARTIDA";
      gameStatus.style.color = "red";
    }

    // Volver al lobby en 3 segundos
    setTimeout(() => {
      currentGameId = null;
      showSection('lobby');
      fetchRanking(); // Actualizar ranking
    }, 4000);
  });

  // Evento: Error
  socket.on('server:error', (data) => {
    alert(data.message);
  });
}

// --- HELPERS DE UI ---

function renderGamesList(games: any[]) {
  gamesList.innerHTML = '';
  if (games.length === 0) {
    gamesList.innerHTML = '<li>No hay partidas. ¡Crea una!</li>';
    return;
  }

  games.forEach(game => {
    const li = document.createElement('li');
    // Asumimos que game tiene game.creator.name
    const creatorName = game.creator?.name || `Jugador (ID: ${game.creator_id})`;
    li.innerText = `Partida de ${creatorName} `;

    // Botón unirse si no soy yo
    if (game.creator_id !== currentUser!.id) {
      const joinBtn = document.createElement('button');
      joinBtn.innerText = "Unirse";
      joinBtn.onclick = () => joinGame(game.id);
      li.appendChild(joinBtn);
    }

    gamesList.appendChild(li);
  });
}

function waitingForOpponentState() {
  gameStatus.innerText = "⏳ Esperando oponente...";
  gameStatus.style.color = "orange";
  myMoveDisplay.innerText = "?";
  oppMoveDisplay.innerText = "?";
}

function resetBoard() {
  myMoveDisplay.innerText = "🤔";
  oppMoveDisplay.innerText = "🤔";
}

// --- ACCIONES DEL USUARIO ---

function createGame() {
  if (!socket) return;
  socket.emit('client:create_game', { userId: currentUser!.id, type: 'human' });
}

function joinGame(gameId: number) {
  if (!socket) return;
  socket.emit('client:join_game', { gameId, userId: currentUser!.id });
}

function makeMove(choice: string) {
  if (!socket || !currentGameId) return;

  // Feedback visual inmediato
  creatorText.innerText = `Tú`;
  opponentText.innerText = `Rival`;
  myMoveDisplay.innerText = choice === 'rock' ? '🪨' : choice === 'paper' ? '📄' : '✂️';
  gameStatus.innerText = "Esperando al rival...";

  socket.emit('client:make_move', {
    gameId: currentGameId,
    userId: currentUser!.id,
    choice
  });
}

function leaveGame() {
  if (!socket) return;
  socket.emit('client:leave_game', { gameId: currentGameId });
  showSection('lobby');
  currentGameId = null;
  gameStatus.innerText = "En juego...";
}

// --- EVENT LISTENERS ---

btnLogin.addEventListener('click', () => handleAuth('login'));
btnRegister.addEventListener('click', () => handleAuth('register'));
btnCreateHuman.addEventListener('click', createGame);
btnLeave.addEventListener('click', leaveGame);
btnRefreshRanking.addEventListener('click', fetchRanking);

moveButtons.forEach(btn => {
  btn.addEventListener('click', (e) => {
    const move = (e.target as HTMLButtonElement).dataset.move;
    if (move) makeMove(move);
  });
});
btnCreateCpu.addEventListener('click', () => {
  if (!socket) return;
  // Enviamos type: 'cpu'
  socket.emit('client:create_game', { userId: currentUser!.id, type: 'cpu' });
});
// Inicialización
showSection('login');