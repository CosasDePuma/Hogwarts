
const mysql = require('mysql2');

// Config
const DB_HOST = process.env.DB_HOST || '127.0.0.1';
const DB_USER = process.env.DB_USER || 'root';
const DB_PASS = process.env.DB_PASS || 'toor';
const DB_NAME = process.env.DB_NAME || 'tiktak';

// Database
const connection = mysql.createConnection({
    host:       DB_HOST,
    user:       DB_USER,
    password:   DB_PASS,
    database:   DB_NAME,
});
connection.connect(error => {
    if(error) throw error;
});

module.exports = connection;