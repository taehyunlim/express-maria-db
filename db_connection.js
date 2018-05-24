const mysql = require('mysql');
const connection = mysql.createConnection({
  host: '52.160.69.254',
  user: 'wms',
  password: '1951zinus',
  database: 'wms'
});

connection.connect(() => {
  connection.query('SELECT * FROM r_innout', (error, results, fields) => {
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
