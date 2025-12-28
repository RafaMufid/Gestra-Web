const userService = require('../services/userService');
const jwt = require('jsonwebtoken');

exports.register = async (req, res) => {
  try {
    await userService.register(req.body);
    res.json({ success: true, message: 'Register success' });
  } catch (err) {
    res.status(400).json({ success: false, message: err.message });
  }
};

exports.login = async (req, res) => {
  try {
    const user = await userService.login(req.body.email, req.body.password);

    const token = jwt.sign(
      { id: user.id },
      process.env.JWT_SECRET,
      { expiresIn: '1d' }
    );

    res.json({
      success: true,
      token,
      user: {
        id: user.id,
        username: user.username,
        email: user.email,
        profile_photo_path: user.profile_photo_path
      }
    });
  } catch (err) {
    res.status(401).json({ message: err.message });
  }
};