//Routes cho sản phẩm
const express = require('express');
const router = express.Router();
const productController = require('../controllers/productController');

// Danh sách sản phẩm
router.get('/', productController.list);

// Chi tiết sản phẩm theo id
router.get('/:id', productController.detail);

module.exports = router;