
import bcrypt from 'bcrypt';
import { User, Game } from '../model/associations.js';
import { Sequelize } from 'sequelize';


//controlador basico de usuario
export const register = async (req, res) => {
    try {
        const { name, email, password } = req.body;

        //encripto la contra
        const hashedPassword = await bcrypt.hash(password, 10);

        //creo el usuario
        const user = await User.create({
            name,
            email,
            password: hashedPassword
        });

        res.status(201).json({ message: "Usuario creado correctamente", data: { id: user.id, name: user.name, email: user.email } });

    } catch (error) {
        res.status(400).json({ error: error.message });
    }

};


export const login = async (req, res) => {
    try {
        const { email, password } = req.body;
        const user = await User.findOne({ where: { email } });

        if (!user) return res.status(404).json({ error: "Usuario no encontrado" });

        const validPassword = await bcrypt.compare(password, user.password);
        if (!validPassword) return res.status(401).json({ error: "Contraseña incorrecta" });
        //hubise generado un sistema de tokens...
        res.json({ message: "Login correcto", data: { id: user.id, name: user.name } });

    } catch (error) {
        res.status(500).json({ error: error.message });
    }
};



export const getRanking = async (req, res) => {
    try {
        //obtengo todos los usuarios e incluyo las partidas ganadas
        //ver si al menos existe una partida para controlar el error 500
        const existGames = await Game.findOne();
        if (existGames) {
            const users = await User.findAll({
                attributes: ['id', 'name'],
                include: [
                    { model: Game, as: 'won_games' },
                    { model: Game, as: 'created_games' },
                    { model: Game, as: 'opponent_games' }
                ]
            });

            const ranking = users.map(user => {
                const played = user.created_games.length + user.opponent_games.length;
                const won = user.won_games.length;
                const winRate = played > 0 ? (won / played) * 100 : 0;
                return {
                    name: user.name,
                    played,
                    won,
                    winRate: winRate.toFixed(2)
                };
            });

            ranking.sort((a, b) => b.winRate - a.winRate); //algoritmo de ordenación automatica
            res.json(ranking);
        }else{
            res.status(404).json({ message: "No existen partidas en la base de datos" });
        }


    } catch (error) {
        console.error({ "mensaje": 'Error en el back', "error": error });
        res.status(500).json({ error: error });
    }
}