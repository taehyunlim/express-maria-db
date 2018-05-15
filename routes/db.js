var mysql = require('mysql');
var connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '1234',
  database: 'zinus_db'
});
var moment = require('moment');

connection.connect();

exports.list = (req, res) => {
  connection.query('SELECT * FROM daily_io', (err, rows) => {
      if (err) throw err;
      res.render('index', {page_title: 'Daily In/Out', data: rows, moment: moment});
  })
}
