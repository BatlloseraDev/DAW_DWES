const { fakerES } = require('@faker-js/faker');

const genUsers = (ctos = 1) => {
  let usersGen = [];
  for (let i = 0; i < ctos; i++) {
    usersGen.push({
      dni: fakerES.person.identifier(),
      nombre: fakerES.person.fullName(),
      clave: '1234',
      edad: Math.floor(Math.random() * 100) + 1
    });
  }
  return usersGen;
};

module.exports = { genUsers };