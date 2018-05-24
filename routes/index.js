'use strict';
var data = require('./db.js');

module.exports = function(app) {
    app.get('/', data.list);

    app.get('/db/filter/date/:date', (req, res) => {
        let date = req.params.date;
        data.filterDate(date, res);
    })

    app.get('/db/filter/date/:date/json', (req, res) => {
        let date = req.params.date;
        data.filterDateJSON(date, res);
    })

    app.get('/faq', function(req, res) {
        res.render('faq');
    });

    app.get('/about', function(req, res) {
        res.render('pages/about');
    });
};
