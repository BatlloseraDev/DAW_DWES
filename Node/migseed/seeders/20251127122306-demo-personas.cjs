'use strict';
//const {genUsers} = require('../factories/user_factory.cjs');

/** @type {import('sequelize-cli').Migration} */
module.exports = {
  async up (queryInterface, Sequelize) {
    await queryInterface.bulkInsert('personas', [{
      dni: "100A",
      nombre: "Another persona",
      clave: "999"
     },
    {
      dni: "100B",
      nombre: "Another persona",
      clave: "999"
     }], {});
  },

  async down (queryInterface, Sequelize) {
    await queryInterface.bulkDelete('personas', null, {});
  }
};