'use strict';

module.exports = function(app) {
    app.get('/', function(req, res) {
        res.render('index');
    });

    app.get('/faq', function(req, res) {
        res.render('faq');
    });

    app.get('/about', function(req, res) {
        res.render('pages/about');
    });
};
