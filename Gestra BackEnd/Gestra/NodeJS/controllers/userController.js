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

exports.updateProfile = async (req, res) => {
  console.log('REQ BODY:', req.body);

  const userId = req.userId;
  const user = await userService.updateProfile(userId, req.body);

  res.json({
    message: 'profile updated',
    user
  });
};

exports.updatePhoto = async (req, res) => {
  try {
    if (!req.file) {
      return res.status(400).json({ message: 'No photo uploaded' });
    }

    const userId = req.userId;
    const photoPath = `profile_photos/${req.file.filename}`;

    await userService.updateProfile(userId, {
      profile_photo_path: photoPath
    });

    const user = await userService.getById(userId);

    res.json({
      message: 'photo updated',
      user
    });
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
};
