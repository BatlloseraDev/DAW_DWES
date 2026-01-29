import User from './User.js';
import Game from './Game.js';
import Round from './Round.js';

// --- RELACIONES USER <-> GAME ---

// Creador de la partida
User.hasMany(Game, { foreignKey: 'creator_id', as: 'created_games' });
Game.belongsTo(User, { foreignKey: 'creator_id', as: 'creator' });

//  Oponente de la partida
User.hasMany(Game, { foreignKey: 'opponent_id', as: 'opponent_games' });
Game.belongsTo(User, { foreignKey: 'opponent_id', as: 'opponent' });

// Ganador de la partida
User.hasMany(Game, { foreignKey: 'winner_id', as: 'won_games' });
Game.belongsTo(User, { foreignKey: 'winner_id', as: 'winner' });


// --- RELACIONES GAME <-> ROUND ---

Game.hasMany(Round, { foreignKey: 'game_id', as: 'rounds' });
Round.belongsTo(Game, { foreignKey: 'game_id', onDelete: 'CASCADE' });



export { User, Game, Round };