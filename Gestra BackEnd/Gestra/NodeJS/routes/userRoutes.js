
const express = require('express');
const router = express.Router();
const controller = require('../controllers/userController');
const auth = require('../middlewares/auth');


// test route
router.get('/', (req, res) => {
  res.json({ message: 'User API works' });
});

// auth routes
router.post('/register', controller.register);
router.post('/login', controller.login);

router.post('/profile/update', auth, controller.updateProfile);
router.post('/profile/photo', auth, controller.updatePhoto);

module.exports = router;

