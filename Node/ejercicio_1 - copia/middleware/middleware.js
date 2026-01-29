


const diaValido = (req,res,next)=>{
    if(req.params.dia <=0 || req.params.dia > 365){
        return res.status(203).json({'msg':'Dia invalido, debe estar entre 1 y 365'})
    }else{
        next()
    }
}

const binarioValido = (req,res,next)=>{
    let contiene= false;
    for(let i = 0; i < req.params.numeroBinario.length; i++){
        if(req.params.numeroBinario[i] != 0 && req.params.numeroBinario[i] != 1){
            contiene = true;
        }
    }

    if(contiene){
        return res.status(203).json({'msg':'no es un numero binario'})
    }
    else{
        next();
    }
    
}

const esNumerico = (req,res,next)=>{
    if(isNaN(req.params.numero)){
        return res.status(203).json({'msg':'no es un numero'})
    }
    else{
        next();
    }

}

export {
    diaValido,
    binarioValido,
    esNumerico


}