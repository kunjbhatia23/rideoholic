const express = require("express");
const mysql = require("mysql");
const dotenv = require('dotenv');
const path = require("path");

dotenv.config({ path: './.env' })

const app = express();
const port = process.env.PORT || 3000;

const con = mysql.createConnection({
    host: process.env.DATABASE_HOST, // Change this to your host
    user: process.env.DATABASE_USER, // Replace with your MySQL username
    password: process.env.DATABASE_PASSWORD, // Replace with your MySQL password
    database: process.env.DATABASE, // Replace with your database name
});

app.use(express.static(path.join(__dirname, 'public')));


con.connect((error) => {
    if (error) {
        console.log(error);
    } else {
        console.log("connected to mysql")
    }
});

app.use('/', require('./routes/routes'));
app.use('/auth', require('./routes/auth'));



app.listen(port, () => {
    console.log(`Server is running at port ${port}`);
});