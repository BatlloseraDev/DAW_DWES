import { response, request } from 'express';
import { Conexion } from '../database/connection.js';
import chalk from 'chalk';

const gameController = {
    startNewGame: (req = request, res = response) => {
        const conx = new Conexion();
        const { playerName } = req.body;

        conx.getRandomWord()
            .then(wordRow => {
                if (!wordRow) {
                    throw new Error('NO_DICTIONARY');
                }
                const targetWord = wordRow.word; //la palabara aleatoria

                //creo la partida con esa palabra y controlo el caso de que no haya nombre de jugador aunque no deberia de pasar
                return conx.createGame(playerName || 'Anonimo', targetWord);
            })
            .then(gameId => {
                console.log(chalk.blue(`🔵 Partida iniciada ID: ${gameId}`));
                res.status(201).json({
                    msg: 'Partida iniciada correctamente',
                    gameId: gameId,
                    attemptsMax: 5,
                    wordLength: 5
                });
            })
            .catch(err => {
                //manejo de errores
                console.error(chalk.red('❌ Error:', err));
                if (err.message === 'NO_DICTIONARY') {
                    return res.status(500).json({ error: `${chalk.yellow.bold('El diccionario está vacío.')}` });
                }
                return res.status(500).json({ error: `${chalk.yellow.bold('Error al iniciar la partida')}` });
            });
    },

    //hacer un intento
    makeAttempt: (req = request, res = response) => {
        const conx = new Conexion();
        const {gameId, wordTried} = req.body;//wordTried es la palabra que se utiliza en el intento

        let gameData = null;

        conx.getGame(gameId)
            .then(game =>{
                if(!game){//lanzo el error para ir al catch porque no encontro ninguna partida
                    throw new Error('GAME_NOT_FOUND');
                }

                gameData= game;

                //validaciones y controladores
                if(gameData.is_solved){
                    throw new Error('GAME_ALREADY_SOLVED');
                }
                if (gameData.attempts_count >= 5) {
                    throw new Error('GAME_OVER');
                }


                //logica del juego
                const target = gameData.target_word.toLowerCase();
                const attempt = wordTried.toLowerCase();
                const result = [];

                if(attempt.length !=5){
                    throw new Error ('INVALID_LENGTH');
                }

                //comparo las palabras
                let targetArr = target.split('');
                let attemptArr = attempt.split('');

                //busco las coincidencias exactas

                let targetUsed = [false, false, false, false, false];

                for (let i= 0; i<5 ; i++){
                    if(attemptArr[i] === targetArr[i]){
                        result[i] = 'pink';
                        targetUsed[i] = true;
                    }else{
                        result[i] =null;
                    }
                }


                //segundo compruebo las palabras que esten en una posicion incorrecta
                for (let i = 0; i<5; i++){//el 5 se puede cambiar por una variable global
                    if(result[i]===null){
                        const letterIndex = targetArr.findIndex((l,idx)=> l === attemptArr[i] && !targetUsed[idx]); //esta funcion se la pedi a la ia en funcion de lo que estaba creando

                        if(letterIndex !==-1){
                            result[i] = 'yellow';
                            targetUsed[letterIndex] = true;
                        } else{
                            result[i]= 'grey';// no existe
                        }
                    }
                }

                //comprobar si ha ganado 
                const isWin = result.every(color => color === 'pink');
                const newAttempts = gameData.attempts_count + 1;

                //Guardar en la base de datos
                return conx.postTryOnGame(gameId, newAttempts, isWin, attempt)
                    .then(() => {
                        return { result, isWin, newAttempts, target }; // Pasamos datos al siguiente bloque
                    });
            })
            .then(data=>{
                const {result, isWin, newAttempts, target} = data;

                console.log(chalk.blue(`Intento registrado`));
                let targetArr = target.split('');


                let hint = ['-','-','-','-','-'];
                for(let i= 0; i<result.length; i++){
                    if(result[i]=='pink'){
                        hint[i]=targetArr[i];
                    }
                    else if(result[i]=='yellow'){
                        hint[i]= '*';
                    }
                }

                res.status(200).json({
                    msg: 'Intento procesado', 
                    clues: hint,
                    attemptsUsed: newAttempts,
                    attemptsLeft: 5 - newAttempts,
                    isSolved: isWin,
                    gameOver: newAttempts >= 5 && !isWin,
                    solution: (isWin||newAttempts>=5) ? target : null
                });
            })
            .catch(err=>{
                if (err.type === 'custom') {
                    if (err.message === 'GAME_NOT_FOUND') return res.status(404).json({ error: 'Partida no encontrada' });
                    if (err.message === 'GAME_ALREADY_SOLVED') return res.status(400).json({ error: 'Esta partida ya fue ganada' });
                    if (err.message === 'GAME_OVER') return res.status(400).json({ error: 'Juego terminado, no quedan intentos' });
                    if (err.message === 'INVALID_LENGTH') return res.status(400).json({ error: 'La palabra debe tener 5 letras' });
                }

                console.error('❌ Error interno:', err);
                res.status(500).json({ error: `Error interno del servidor: ${err}` });
            });



    }

};

export default gameController;

