// khởi chạy Express.js
const express = require('express');
const path = require('path');


require('dotenv').config();

const app = express();

// view engine

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname,'views'));

// middleware

app.use(express.json());
app.use(express.urlencoded({extends: false}));

app.use(express.static(path.join(__dirname,'public')));


// sension va flash
app.use(session({
    secret: 'your-secret-key', // Thay đổi secret cho phù hợp
    resave: false,
    saveUninitialized: true,
  }));
  app.use(flash());

//route

const indexRoute = require('./routes/index');
const productRoute = require('./routes/product');

app.use('/', indexRoute);
app.use('/products', productRoute);

// check db connect
const db = require('./config/config');
db.query('SELECT 1')
  .then(() => console.log('Kết nối MySQL thành công'))
  .catch(err => console.error('Lỗi kết nối MySQL:', err));


// port

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server đang chạy trên cổng ${PORT}`);
});