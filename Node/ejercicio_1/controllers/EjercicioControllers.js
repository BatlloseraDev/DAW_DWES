

const controlador = {
    funCalcularFecha: (req, res) => {
        
        let diaDelAnio = parseInt(req.params.dia);
        const diasEnMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        let mes = 0;

        for (let i = 0; i < diasEnMes.length; i++) {
            if(diaDelAnio <= diasEnMes[i] && mes === 0){
                mes = i + 1;
            }
            else if (diaDelAnio > diasEnMes[i]) {
                diaDelAnio -= diasEnMes[i];
            }
        }

        res.status(200).json({ mes: mes, dia: diaDelAnio });
    },

    funComplementoBinario: (req, res) => {
        const numeroBinario = req.params.numeroBinario;
        let complementoA1 = '';

        for (const bit of numeroBinario) {
            complementoA1 += (bit === '0' ? '1' : '0');
        }

        res.status(200).json({ original: numeroBinario, complemento_a1: complementoA1 });
    },

    funEjercitos: (req, res) => {
        let numero = parseInt(req.params.numero);

        let cuadrados = [];
        let numAux = numero;

        while (numero >= 1) {
            let dividido=false;

            while(!dividido){
                let temporal = numAux*numAux;
                if(temporal <= numero){
                    numero -= temporal;                
                    cuadrados.push(numAux);
                    numAux= numero;
                    dividido=true;
                }
                else{
                    numAux--;
                    
                }
            }

        }

        let escudosTotales= 0;
        for(let i = 0; i < cuadrados.length; i++){
            let numeroCalculado = cuadrados[i]*cuadrados[i];
            
            if(numeroCalculado!=1){    
                let contorno = cuadrados[i]*4 -4;
                escudosTotales += numeroCalculado - contorno; //le resta el perimetro cuadrado al total quedando los del centro
                contorno -= 4;//quito las equinas
                escudosTotales += contorno*2; //sumo los escudos que necesitan los soldados del contorno que no estan en las equinas
                escudosTotales += 4*3; // sumo los escudos que necesitan los soldados de las esquinas
            }
            else if(numeroCalculado==1){
                escudosTotales += 5;
            }

        }


        return res.status(200).json({ cuadrados: cuadrados, escudos_totales: escudosTotales});
    }
}

export default controlador