const express = require('express');
const mysql = require('mysql');

const app = express();

const connection = mysql.createConnection({
  host: 'localhost', // Replace with your host name
  user: 'root', // Replace with your database username
  password: '', // Replace with your database password
  database: 'rideoholic' // Replace with your database name
});

connection.connect((err) => {
  if (err) {
    console.error('Error connecting to database: ' + err.stack);
    return;
  }
  console.log('Connected to the database.');
});

app.get('/dealers', (req, res) => {
  connection.query('SSELECT * from DEALERS', (error, results, fields) => {
    if (error) throw error
    res.send('The solution is: ' + results[0].solution)
  });
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});