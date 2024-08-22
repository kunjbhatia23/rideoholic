const express = require('express');
const authController = require('../controllers/auth.js');
const path = require("path");

const router = express.Router();


router.post('/', authController.register);

module.exports = router;
