import mysql from 'mysql2';
import chalk from 'chalk';
import dotenv from 'dotenv';

dotenv.config();

class Conexion {
    constructor(options) {
        this.config = {
            host: process.env.DB_URL,
            user: process.env.DB_USER,
            password: process.env.DB_PASSWORD,
            database: process.env.DB_NAME,
            connectionLimit: process.env.DB_MAXCONNECTIONS,
            port: process.env.DB_PORT
        };

        try {
            this.pool = mysql.createPool(this.config);

            this.pool.getConnection((err, connection) => {
                if (err) console.log(chalk.red.bold('❌ Error en la conexión de la bd: '), err);
                else {
                    console.log(chalk.blue.bold('🔵 Conexión con la BD establecida con éxito'));
                    connection.release();
                }
            });
        } catch (error) {
            console.log(chalk.red.bold('❌ Error en la conexión de la bd: '), error)
        }

        //esto cierra la pool
        process.on('SIGINT', async () => {
            try {
                await this.pool.end();
                console.log(chalk.cyan.bold('✅ Conexiones con la BD cerradas correctamente.'));
                process.exit(0);
            } catch (error) {
                console.error(chalk.red.bold('Error al cerrar el pool:', error));
                process.exit(1);
            }
        });
    }

    //metodo para ejecutar las querys
    query = (sql, values) => {
        return new Promise((resolve, reject) => {
            this.pool.query(sql, values, (err, rows) => {
                if (err) {
                    reject(err);
                } else {
                    console.log(chalk.yellow.bold('rows.length === 0: ', rows.length === 0));
                    /*
                           if (rows.length === 0) {
                            reject(err);
                            }
                    */
                    resolve(rows);
                }
            });
        });
    }

    insertWord = async (word) => {
        let result = 0;
        try {
            const wordLower = word.toLowerCase();
            const sql = 'INSERT INTO dictionary (word) VALUES (?)';
            result = await this.query(sql, [wordLower]);

        } catch (error) {
            throw error;
        }
        return result;
    }


    getListWords = async () => {
        let result = [];
        try {
            const sql = 'SELECT * FROM dictionary';
            result = await this.query(sql);
        } catch (error) {
            throw error;
        }
    }

    getRandomWord = async () => {
        let result = '';
        try {
            const sql = 'SELECT * FROM dictionary ORDER BY RAND() LIMIT 1';
            const rows = await this.query(sql);
            result = rows.length > 0 ? rows[0] : null;

        } catch (error) {
            throw error;
        }
        return result
    }

    createGame = async (playerName, targetWord) => {
        let result = 0;
        try {
            const sql = 'INSERT INTO games (player_name, target_word, attempts_count, is_solved) VALUES (?, ?, 0, false)';
            const r_query = await this.query(sql, [playerName, targetWord]);
            result = r_query.insertId;
        } catch (error) {
            throw error;
        }

        return result;
    }

    getGame = async (gameId) => {
        let result = 0;
        try {
            const sql = 'SELECT * FROM games WHERE id= ? ';
            const rows = await this.query(sql, [gameId]);
            result = rows.length > 0 ? rows[0] : null;
        } catch (error) {
            throw error;
        }
        return result;
    }

    postTryOnGame = async (gameId, triesWasted, gameEnded, wordTried) => {
        let result = 0;
        try {
            const sqlUpdate = 'UPDATE games SET attempts_count = ?, is_solved = ? WHERE id = ?';
            const infoUpdate = await this.query(sqlUpdate, [triesWasted, gameEnded, gameId]);

            if (infoUpdate.affectedRows > 0) {
                const sqlHistory = 'INSERT INTO history (game_id, attempt_word, attempt_number) VALUES (?,?,?)';
                const infoHistory = await this.query(sqlHistory, [gameId, wordTried, triesWasted]);
                
                result = infoHistory.insertId;
            }
        }catch (error){
            throw error;
        }
        return result;
    }

    getUserRegistrado = async(email, password) =>{
        let result = [];
        try{
            const sql = 'SELECT * FROM users WHERE email = ? AND password = ?';
            const rows = await this.query(sql, [email, password]);
            result = rows.length > 0 ? rows[0] : null;
            
        }catch(error){
            throw error;
        }
        return result;
    }

    deleteUser = async(id) =>{
        let result = 0;
        try{
            const sql = 'DELETE FROM users WHERE id = ?';
            const rows = await this.query(sql, [id]);
            result = rows.affectedRows;
        }catch(error){
            throw error;
        }
        return result;
    }

    modifyUser = async(id, email, password) =>{
        let result = 0;
        try{
            const sql = 'UPDATE users SET email = ?, password = ? WHERE id = ?';
            const rows = await this.query(sql, [email, password, id]);
            result = rows.affectedRows;
        }catch(error){
            throw error;
        }
        return result;
    }

    registerUser = async(name , email, password) =>{
        let result = 0;
        try{
            const timestamp = require('time-stamp');
            const time = timestamp('YYYY/MM/DD HH:mm:ss');
            const sql = 'INSERT INTO users (name , email, password, created_at) VALUES (?, ? ,?)';
            const rows = await this.query(sql, [name , email, password, time]);
            result = rows.insertId;
        }catch(error){
            throw error;
        }
        return result;
    }

    getUsers = async() =>{
        let result = [];
        try{
            const sql = 'SELECT * FROM users';
            result = await this.query(sql);
        }catch(error){
            throw error;
        }
        return result;
    }

    getUser = async(id) =>{
        let result = [];
        try{
            const sql = 'SELECT * FROM users WHERE id = ?';
            const rows = await this.query(sql, [id]);
            result = rows.length > 0 ? rows[0] : null;
        }catch(error){
            throw error;
        }
        return result;
    }
}

export {Conexion};