export const esUsuario = (req, res, next) =>{
    if(!req.roles.includes('USER_ROLE')){
        return res.status(401).json({
            msg: 'No tiene permisos de usuario'
        });
    }
    console.log('Accediendo como usuario');
    next();

}