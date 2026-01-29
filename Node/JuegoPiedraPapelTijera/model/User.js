import { DataTypes, Model } from "sequelize";
import db from "../database/connection.js";

class User extends Model {}

User.init({
    id: {
        type: DataTypes.INTEGER,
        primaryKey: true,
        autoIncrement: true
    },
    name: {
        type: DataTypes.STRING(255),
        allowNull: false
    },
    email: {
        type: DataTypes.STRING(255),
        allowNull: false,
        unique: true
    },
    password: {
        type: DataTypes.STRING(255),
        allowNull: false
    }
}, {
    sequelize: db,
    modelName: 'User',
    tableName: 'users',
    timestamps: true,
    underscored: true,
    paranoid: true
});

export default User;