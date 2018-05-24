var mysql = require('mysql');
var connection = mysql.createConnection({
  host: '52.160.69.254',
  user: 'wms',
  password: '1951zinus',
  database: 'wms'
});
var moment = require('moment');

connection.connect();

exports.list = (req, res) => {
  connection.query('SELECT * FROM r_innout LIMIT 100', (err, rows) => {
      if (err) throw err;
      res.render('index', {page_title: 'r_innout', data: rows, moment: moment});
  })
}

exports.filterDate = (req, res) => {
  // console.log(req);
  connection.query(`SELECT * FROM r_innout WHERE DT=${req}`, (err, rows) => {
    if (err) throw err;
    // res.send({ page_title: 'r_innout', data: rows });
    res.render('index', { page_title: 'r_innout', data: rows, moment: moment });
  })
}

exports.filterDateJSON = (req, res) => {
  // console.log(req);
  connection.query(`SELECT * FROM r_innout WHERE DT=${req}`, (err, rows) => {
    if (err) throw err;
    res.send({ page_title: 'r_innout', data: rows });
  })
}