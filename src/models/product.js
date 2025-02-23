//model sản phẩm
// models/product.js
const db = require('../config/config');

module.exports = {
  getAll: async function () {
    const [rows] = await db.query('SELECT * FROM products');
    return rows;
  },
  getById: async function (id) {
    const [rows] = await db.query('SELECT * FROM products WHERE id = ?', [id]);
    return rows[0];
  }
};
