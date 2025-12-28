
const express = require('express');
const router = express.Router();
const controller = require('../controllers/userController');

// test route
router.get('/', (req, res) => {
  res.json({ message: 'User API works' });
});

// auth routes
router.post('/register', controller.register);
router.post('/login', controller.login);

module.exports = router;

