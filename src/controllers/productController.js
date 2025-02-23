// controllers/productController.js
const Product = require('../models/product');

exports.list = async (req, res) => {
  try {
    const products = await Product.getAll();
    res.render('products/list', { title: 'Danh Sách Sản Phẩm', products });
  } catch (error) {
    res.status(500).send(error.message);
  }
};

exports.detail = async (req, res) => {
  try {
    const product = await Product.getById(req.params.id);
    if (!product) return res.status(404).send('Không tìm thấy sản phẩm');
    res.render('products/detail', { title: 'Chi Tiết Sản Phẩm', product });
  } catch (error) {
    res.status(500).send(error.message);
  }
};
