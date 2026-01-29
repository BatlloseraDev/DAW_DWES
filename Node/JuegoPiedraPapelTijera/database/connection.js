import { Sequelize } from 'sequelize';
import kleur from 'kleur';
import dotenv from 'dotenv';
dotenv.config()

let db;

if (!db) {
    console.log('Conexión establecida correctamente.');
    db = new Sequelize(process.env.DB_DEV, process.env.DB_USER, process.env.DB_PASSWORD, {
        host: process.env.DB_HOST,
        dialect: process.env.DB_DIALECT, /* one of 'mysql' | 'postgres' | 'sqlite' | 'mariadb' | 'mssql' | 'db2' | 'snowflake' | 'oracle' */
        pool: {
            max: parseInt(process.env.DB_MAXCONNECTIONS), //Número máximo de conexiones en el grupo de conexiones.
            min: 1, //Número mínimo de conexiones en el grupo de conexiones.
            acquire: 30000, //Tiempo máximo, en milisegundos, que un grupo de conexiones intentará adquirir una conexión antes de lanzar un error.
            idle: 10000, //Tiempo máximo, en milisegundos, que una conexión puede estar inactiva antes de ser liberada.
        },
        logging: console.log //Habilita el registro de consultas, las consultas se lanzan por consola.
    });
}

//Probar conexión una vez al inicio. La primera conexión real ocurre al usar authenticate() o hacer consultas.
//authenticate() intenta conectarse a la base de datos una vez para validar las credenciales. Si funciona, el pool de Sequelize queda inicializado.
(async () => {
  try {
    await db.authenticate();
    console.log(kleur.blue().bold('🔵 Conexión con la BD establecida con éxito'));
  } catch (err) {
    console.error(kleur.red().bold('💀 Error en la conexión de la bd: '), err);
  }
})();



//Manejo de cierre de la app
const cerrarConexion = async () => {
    try {
        console.log(kleur.yellow().bold("🟡 Cerrando conexiones con la BD..."));
        await db.close();
        console.log(kleur.green().bold("🖖🏻 Conexiones con la BD cerradas correctamente."));
        process.exit(0);
    } catch (err) {
        console.error(kleur.red().bold("☠️ Error al cerrar la BD:"), err);
        process.exit(1);
    }
};

process.on("SIGINT", cerrarConexion);   // Ctrl+C
process.on("SIGTERM", cerrarConexion);  // Terminar proceso
process.on("SIGQUIT", cerrarConexion);  // Salida de shell



export default db;

