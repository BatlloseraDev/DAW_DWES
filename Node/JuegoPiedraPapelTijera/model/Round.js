import { DataTypes, Model } from "sequelize";
import db from "../database/connection.js";

class Round extends Model {}

Round.init({
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    game_id: {
        type: DataTypes.INTEGER,
        allowNull: false
    },
    creator_choice: {
        type: DataTypes.ENUM('rock', 'paper', 'scissors'),
        allowNull: true 
    },
    opponent_choice: {
        type: DataTypes.ENUM('rock', 'paper', 'scissors'),
        allowNull: true
    },
    round_number: {
        type: DataTypes.INTEGER,
        allowNull: false
    }
}, {
    sequelize: db,
    modelName: 'Round',
    tableName: 'rounds',
    timestamps: false,
    underscored: true
});

export default Round;