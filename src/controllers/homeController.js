exports.index = (req, res) => {
    res.render('index', { title: 'Trang chủ', message: req.flash('info') });
  };