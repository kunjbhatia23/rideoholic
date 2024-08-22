const express = require('express');
const mysql = require('mysql');
const app = express();
const port = 3000;

// Create a MySQL connection
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'your_username',
  password: 'your_password',
  database: 'your_database_name',
});

// Connect to the database
connection.connect((err) => {
  if (err) throw err;
  console.log('Connected to the database!');
});

// Create a POST route to handle form submissions
app.post('/submit-form', (req, res) => {
  const { fullName, phoneNumber, email, password } = req.body;
  const formData = { fullName, phoneNumber, email, password };

  // Insert the form data into a table
  connection.query('INSERT INTO your_table_name SET ?', formData, (error, results, fields) => {
    if (error) throw error;
    res.send('Form data has been saved to the database!');
  });
});

app.listen(port, () => {
  console.log(`Server is running at http://localhost:${port}`);
});
