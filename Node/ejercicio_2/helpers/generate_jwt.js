import jwt from 'jsonwebtoken';
import dotenv from 'dotenv';

dotenv.config();

export const generarJWT = (uid = '') => {
    return jwt.sign({ uid },
        process.env.SECRETORPRIVATEKEY,
        {
            expiresIn: '4h'
        });
}

export const generarJWT_Roles = (uid = '', roles = []) => {
    return jwt.sign({ uid, roles },
        process.env.SECRETORPRIVATEKEY,
        {
            expiresIn: '4h'
        });

}