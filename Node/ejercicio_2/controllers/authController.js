import { response, request } from "express";
import { Conexion } from "../database/connection.js";
import chalk from "chalk";
import { generarJWT, generarJWT_Roles } from "../helpers/generate_jwt.js";



export const login = (req,res = response) =>{
    const {email, password} = req.body;

    //lógica de autenticación aquí
    try{
        const conx = new Conexion();
        const u = conx.getUserRegistrado(email, password)
            .then(user =>{
                console.log('Usuario correcto!'+user.name);
                const token = generarJWT_Roles(user.email, ['USER_ROLE']);

                console.log(user);
                console.log(token);
                res.status(200).json({user,token});
                
            })
            .catch( err =>{
                console.log('No hay registro de ese usuario');
                res.status(500).json({'msg':'No hay registro de ese usuario', "error": err});
            
            })

    }catch(err){
        console.log(err);
        res.status(500).json({'msg':'Error interno del servidor'});
    }


}

