const mysql = require('mysql');
const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'localhost',
  password: 'localhost123',
  database: 'rideoholic'
});

connection.connect((err) => {
  if (err) throw err;
  console.log('Connected to MySQL database');
});

rl.question('Enter your username: ', (username) => {
  rl.question('Enter your email: ', (email) => {
    rl.question('Enter your password: ', (password) => {
      const userData = { username, email, password };
      connection.query('INSERT INTO users SET ?', userData, (error, results, fields) => {
        if (error) throw error;
        console.log('User registered successfully.');
        rl.close();
        connection.end();
      });
    });
  });
});

rl.on('close', () => {
  console.log('\nConnection to MySQL closed');
  process.exit(0);
});
