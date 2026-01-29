import { response, request } from "express";
import { Conexion } from "../database/connection.js";
import chalk from "chalk";

const conx = new Conexion();

const userController = {
    usersGet: (req = request, res = response) => {
        conx.getUsers()
            .then(msg => {
                console.log('🔵 Listado correcto!');
                res.status(200).json(msg);
            })
            .catch(err => {
                // Error de conexión
                if (err && err.code === 'ER_ACCESS_DENIED_ERROR') {
                    return res.status(500).json({
                        error: 'Error de conexión a la Base de Datos (credenciales incorrectas)'
                    });
                }
                if (err && err.code === 'ECONNREFUSED') {
                    return res.status(500).json({
                        error: 'No se puede conectar al servidor MySQL'
                    });
                }
                // Sin resultados
                if (err === 'NO_ROWS') {
                    return res.status(404).json({
                        msg: 'No se han encontrado registros'
                    });
                }
                // Cualquier otro error
                res.status(500).json({
                    error: 'Error interno del servidor'
                });
            });
    },
    userGet: (req = request, res = response) => {
        conx.getUser(req.id)
            .then(msg => {
                console.log('🔵 Usuario correcto!');
                res.status(200).json(msg);
            })
            .catch(err => {
                // Error de conexión
                if (err && err.code === 'ER_ACCESS_DENIED_ERROR') {
                    console.error('❌ Error:', err);
                    return res.status(500).json({
                        error: 'Error de conexión a la Base de Datos (credenciales incorrectas)'
                    });
                }
                // Sin resultados
                if (err === null || err === undefined || (Array.isArray(err) && err.length === 0)) {
                    console.error('‼️ No hay registros');
                    return res.status(404).json({
                        msg: 'No se han encontrado registros'
                    });
                }
                // Cualquier otro error
                console.error('❌ Error:', err);
                res.status(500).json({
                    error: 'Error interno del servidor' + err
                });
            });
    },
    userPost: (req = request, res = response) => {
        conx.registerUser(req.body.name, req.body.email, req.body.password)
            .then(msg => {
                console.log('🔵 Registro correcto!');
                res.status(200).json(msg);
            })
            .catch(err => {
                console.log('‼️ Fallo en el registro!');
                res.status(203).json(err);
            });

    },
    userDelete : (req = request, res = response) => {
        conx.deleteUser(req.id)
            .then(msg => {
                console.log('🔵 Usuario eliminado!');
                res.status(200).json(msg);
            })
            .catch(err => {
                console.log('‼️ Fallo en la eliminación!');
                res.status(203).json(err);
            });
    },
    userPut: (req = request, res = response) => {
        conx.updateUser(req.id, req.body)
            .then(msg => {
                console.log('🔵 Usuario actualizado!');
                res.status(200).json(msg);
            })
            .catch(err => {
                console.log('‼️ Fallo en la actualización!');
                res.status(203).json(err);
            });
    }

}

export default userController;