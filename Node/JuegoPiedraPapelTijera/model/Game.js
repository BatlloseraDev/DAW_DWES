import { DataTypes, Model } from "sequelize";
import db from "../database/connection.js";

class Game extends Model {}

Game.init({
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    creator_id: {
        type: DataTypes.INTEGER
    },
    opponent_id: {
        type: DataTypes.INTEGER
    },
    finished: {
        type: DataTypes.BOOLEAN,
        defaultValue: false
    },
    winner_id: {
        type: DataTypes.INTEGER,
        defaultValue: null
    }
}, {
    sequelize: db,
    modelName: 'Game',
    tableName: 'games',
    timestamps: true,
    underscored: true
});

export default Game;