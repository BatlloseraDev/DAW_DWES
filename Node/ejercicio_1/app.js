import express from 'express'
import chalk from 'chalk'
import {diaValido, binarioValido, esNumerico} from './middleware/middleware.js'
import controlador from './controllers/EjercicioControllers.js'


const app = express()
const port = 3000

app.get('/fechas/:dia', [diaValido], controlador.funCalcularFecha)
app.get('/complemeto/:numeroBinario',[binarioValido], controlador.funComplementoBinario)
app.get('/ejercitos/:numero',[esNumerico], controlador.funEjercitos)

app.listen(port,() =>{
    console.log(chalk.bgBlue.white.bold(`Servidor corriendo en el puerto ${port}`))
})