import { check } from "express-validator";
import { validateResult } from "../helpers/validateHelper.js";


const validateStartGame = [
    check('playerName')
        .exists()
        .not()
        .isEmpty().withMessage('El nombre del jugador es obligatorio')
        .isString()
        .isLength({min:2}).withMessage('El nombre debe tener al menos 2 letras'),

        (req, res, next) =>{
            validateResult(req, res, next);
        }
];


const validateAttempt = [
    check('gameId')
        .exists()
        .isNumeric().withMessage('El ID de la partida debe ser un numero'),
    
    check('wordTried')
        .exists()
        .isString()
        .isLength({ min: 5, max: 5 }).withMessage('La palabra debe tener exactamente 5 letras')
        .isAlpha('es-ES', {ignore: ' '}).withMessage('Solo se permiten letras'), // Evita números o símbolos en la palabra

    (req, res, next) => {
        validateResult(req, res, next);
    }
];

export { validateStartGame, validateAttempt };