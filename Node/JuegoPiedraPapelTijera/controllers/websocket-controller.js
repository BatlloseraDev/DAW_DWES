import kleur from 'kleur';
import { User, Game, Round } from '../model/associations.js';
import { Op } from 'sequelize'


//Helpers
const getAvailableGames = async () => {

    return await Game.findAll({
        where: { opponent_id: null, finished: false },
        include: [{ model: User, as: 'creator', attributes: ['name'] }]
    });
};

const getOrCreateCpu = async () => {
    let cpu = await User.findOne({ where: { email: 'cpu@bot.com' } });
    if (!cpu) {
        // Creo un usuario ficticio para la máquina
        cpu = await User.create({
            name: 'Skynet (CPU)',
            email: 'cpu@bot.com',
            password: 'bot_secure_password'
        });
    }
    return cpu;
};

const determineRoundWinner = (c1, c2) => {
    if (c1 === c2) return 'draw';
    if ((c1 === 'rock' && c2 === 'scissors') ||
        (c1 === 'scissors' && c2 === 'paper') ||
        (c1 === 'paper' && c2 === 'rock')) {
        return 'creator';
    }
    return 'opponent';
}
const handleForfeit = async (gameId, loserId, io) => {
    try {
        const game = await Game.findByPk(gameId);
        if (!game || game.finished) return;

        // El ganador es el que NO es el perdedor
        const winnerId = (game.creator_id == loserId) ? game.opponent_id : game.creator_id;

        await game.update({ finished: true, winner_id: winnerId });

        // Avisa a la sala (y obviamente dispara los eventos consecuentes)
        io.to(`game_${gameId}`).emit('server:game_finished', {
            winnerId: winnerId,
            reason: 'opponent_left' 
        });

    } catch (error) {
        console.error("Error gestionando abandono:", error);
    }
};





export const socketController = (socket, io) => {

    const userId = socket.handshake.headers['user-id'];//esto lo he buscado para solucioanr el problema de desconexion de partidas
    console.log(kleur.yellow().bold("Cliente conectado:"), socket.id);

    socket.on("disconnect", () => {
        console.log(kleur.yellow().bold("Cliente desconectado:"), socket.id);
    });

    socket.join('lobby');

    getAvailableGames().then(games => {
        socket.emit('server:available_games', games)
    });


    socket.on('client:create_game', async ({ userId, type }) => {//tipo: humano o cpu
        try {
            //Aqui valida que no tenga ninguna partida activa
            const activeGame = await Game.findOne({
                where: {
                    [Op.or]: [{ creator_id: userId }, { opponent_id: userId }],
                    finished: false
                }
            });
            if (activeGame) {
                return socket.emit('server:error', { message: 'Ya tienes una partida empezada que no has finalizado' });
            }
            let opponentId = null;

            // Busco o creo al usuario Bot
            if (type === 'cpu') {
                const cpuUser = await getOrCreateCpu();
                opponentId = cpuUser.id;
            }

            //crear partida 
            const newGame = await Game.create({
                creator_id: userId,
                opponent_id: opponentId,
                finished: false
            });

            //ahora se une socket a la sala del juego
            const roomName = `game_${newGame.id}`;
            socket.join(roomName);

            socket.emit('server:game_created', { gameId: newGame.id, room: roomName });

            if (type === 'human') {
                //avisar al lobby
                const games = await getAvailableGames();
                io.to('lobby').emit('server:available_games', games);
            } else {
                io.to(roomName).emit('server:game_started', { gameId: newGame.id });
            }

        } catch (error) {
            console.log(error);
            socket.emit('server:error', { message: `Error al crear partida: ${error}` });
        }
    });

    //Humano vs Humano
    socket.on('client:join_game', async ({ gameId, userId }) => {
        try {

            const game = await Game.findByPk(gameId);
            if (!game || game.finished || game.opponent_id) {
                return socket.emit('server:error', { message: 'Partida no encontrada' });
            }
            //ahora valido que no haya ninguna partida activa
            const activeGame = await Game.findOne({
                where: {
                    [Op.or]: [{ creator_id: userId }, { opponent_id: userId }],
                    finished: false
                }
            });
            if (activeGame) {
                return socket.emit('server:error', { message: 'Ya tienes una partida empezada que no has finalizado' });
            }

            //actualizo la partida con el user id del oponente
            await game.update({ opponent_id: userId });

            //uno socket a la sala
            const roomName = `game_${gameId}`;
            socket.join(roomName);
            //avisar a ambos que empieza
            //io.to(roomName).emit(0)
            io.to(roomName).emit('server:game_started', { gameId: gameId });

            const games = await getAvailableGames(); // Función auxiliar para listar partidas
            io.to('lobby').emit('server:available_games', games);

        } catch (error) {
            console.log(error);
            socket.emit('server:errror', { message: `Error al unirse a la partida: ${error}` })
        }
    })
    socket.on('client:make_move', async ({ gameId, userId, choice }) => {
        try {
            const game = await Game.findByPk(gameId);
            if (!game || game.finished) return;

            // Obtiene información de la CPU
            const cpuUser = await getOrCreateCpu();
            const isCpuGame = (game.opponent_id === cpuUser.id);
            const isCreator = (game.creator_id === userId);

            // Calcula el número de ronda correcto
            const rounds = await Round.findAll({
                where: { game_id: gameId },
                order: [['round_number', 'ASC']]
            });

            let currentRoundNum = 1;
            if (rounds.length > 0) {
                const lastRound = rounds[rounds.length - 1];
                // Si la última ronda está completa, paso a la siguiente
                if (lastRound.creator_choice !== null && lastRound.opponent_choice !== null) {
                    currentRoundNum = lastRound.round_number + 1;
                } else {
                    currentRoundNum = lastRound.round_number;
                }
            }

            // Buscar la ronda o la inicializo
            let currentRound = await Round.findOne({
                where: { game_id: gameId, round_number: currentRoundNum }
            });

            if (!currentRound) {
                // Uso build() para preparar el objeto 
                currentRound = Round.build({
                    game_id: gameId,
                    round_number: currentRoundNum,
                    creator_choice: null,
                    opponent_choice: null
                });
            }

            // Aplicar jugada del humano
            if (isCreator) currentRound.creator_choice = choice;
            else currentRound.opponent_choice = choice;

            // Si es juego vs cpu y el humano acaba de tirar, la cpu responde.
            if (isCpuGame && isCreator) {
                const moves = ['rock', 'paper', 'scissors'];
                const randomMove = moves[Math.floor(Math.random() * moves.length)];
                currentRound.opponent_choice = randomMove;
            }

            //Guarda en Base de Datos 
            await currentRound.save();

            //Verifica si la ronda terminó (Ambos tienen la jugada)
            if (currentRound.creator_choice && currentRound.opponent_choice) {

                const result = determineRoundWinner(currentRound.creator_choice, currentRound.opponent_choice);

                io.to(`game_${gameId}`).emit('server:round_result', {
                    round: currentRoundNum,
                    creator: currentRound.creator_choice,
                    opponent: currentRound.opponent_choice,
                    winner: result
                });

                //Verificar ganador de la partida
                const allRounds = await Round.findAll({ where: { game_id: gameId } });
                let creatorWins = 0;
                let opponentWins = 0;

                allRounds.forEach(r => {
                    const w = determineRoundWinner(r.creator_choice, r.opponent_choice);
                    if (w === 'creator') creatorWins++;
                    if (w === 'opponent') opponentWins++;
                });

                if (creatorWins >= 3 || opponentWins >= 3) {
                    const winnerId = creatorWins >= 3 ? game.creator_id : game.opponent_id;
                    await game.update({ finished: true, winner_id: winnerId });

                    io.to(`game_${gameId}`).emit('server:game_finished', {
                        winnerId: winnerId
                    });
                }
            }

        } catch (error) {
            console.error(error);
            socket.emit('server:error', { message: `Error: ${error.message}` });
        }
    });


    // --- ABANDONO VOLUNTARIO ---
    socket.on('client:leave_game', async ({ gameId }) => {
        await handleForfeit(gameId, userId, io);
        socket.leave(`game_${gameId}`); // Sacamos al usuario de la sala
    });

    //un control un poco brusco de si se te cae la conexion o cierras el navegador en una partida
    socket.on('disconnect', async () => {
        console.log(`Cliente desconectado: ${socket.id}`);

        if (userId) {
           
            const activeGame = await Game.findOne({
                where: {
                    [Op.or]: [{ creator_id: userId }, { opponent_id: userId }],
                    finished: false
                }
            });

            if (activeGame) {
                await handleForfeit(activeGame.id, userId, io);
            }
        }
    });
    // socket.join('lobby');

    // socket.emit('server:available_games', listaDePartidas);
    // socket.emit('server:ranking_update', rankingData);


    // socket.on("")

    // socket.on("disconnect", ()=>{
    //     console.log(kleur.yellow().bold("Cliente desconectado:"), socket.id);
    // });

    // socket.on("enviar-mensaje", (payload, callback)=>{
    //     console.log("Payload recibido")
    // })

}