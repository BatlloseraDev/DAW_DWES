# REGLAS PARA JANKENPO (piedra papel o tijera en japones)


## Despliegue

1. Paso
Inicia tu servidor en xampp por ejemplo y crea una database con este nombre `node_jankenpo_dev`
en caso que no quieras usar este nombre cambia los archivos de configuracion en `.env`

2. Paso
En el directorio raiz abre una terminal y ejecuta 
```bash
npm install
#una vez todos instalados ejecuta
nodemon
```

3. Paso
Abre otro terminal y muevete al directorio `./socket-client-ts`

```bash
cd .\socket-client-ts\

``` 
4. Paso
Instala los paquetes necesarios y empieza la aplicación
```bash
npm install
#una vez todos instalados ejecuta
npm run dev
```

## Uso
- Por defecto (para flexibilidad de desarrollo) deje los campos iniciados de correo y contraseña

- Para poder entrar antes tienes que registar una cuenta
    - al crear solo una cuenta ya tienes acceso a poder jugar contra la cpu
    - al principio no cargará ninguna estadistica en ranking por que no existe ninguna partida
- Para poder jugar inicia sesion con otra cuenta

- He adaptado la logica del mejor de 5 y es que como puede haber empates no cuento victoria para ninguno por lo que pueden generarse más rondas de 5

- El sistema contempla todos los casos incluso las desconexiones de partidas

- Por falta de tiempo no he podido aplicar tests