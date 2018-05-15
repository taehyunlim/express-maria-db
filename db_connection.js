const mysql = require('mysql');
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '1234',
  database: 'zinus_db'
});

connection.connect(() => {
  connection.query('SELECT * FROM daily_io', (error, results, fields) => {
    if (error) throw error;
    console.log(results);
  });
});
// 
// connection.query('SELECT * FROM daily_io', (error, results, fields) => {
//   if (error) throw error;
//   console.log(results);
// });
//
// connection.end();
