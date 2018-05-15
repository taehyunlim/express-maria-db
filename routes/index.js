'use strict';
var data = require('./db.js');

module.exports = function(app) {
    app.get('/', data.list);

    app.get('/faq', function(req, res) {
        res.render('faq');
    });

    app.get('/about', function(req, res) {
        res.render('pages/about');
    });
};
