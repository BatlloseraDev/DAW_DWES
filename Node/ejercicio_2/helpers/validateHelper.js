import { validationResult } from "express-validator";
//este es el validar campos de fernando

const validateResult = (req,res,next)=>{
    try{
        validationResult(req).throw();
        return next();
    } catch(err){
        res.status(403).send({errors: err.array()});
    }
};

export {validateResult};