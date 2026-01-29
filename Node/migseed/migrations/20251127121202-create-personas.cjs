'use strict';
module.exports = {
  async up(queryInterface, Sequelize) {
    await queryInterface.createTable('personas', {
      dni: {
        allowNull: false,
        primaryKey: true,
        type: Sequelize.STRING
      },
      nombre: Sequelize.STRING,
      clave: Sequelize.STRING,
      edad: Sequelize.INTEGER
    });
  },
  async down(queryInterface, Sequelize) {
    await queryInterface.dropTable('personas');
  }
};
