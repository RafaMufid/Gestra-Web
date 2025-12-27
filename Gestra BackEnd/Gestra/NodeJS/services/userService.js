const bcrypt = require('bcryptjs');
const userRepo = require('../repositories/userRepository');

exports.register = async (data) => {
  const exist = await userRepo.findByEmail(data.email);
  if (exist) throw new Error('Email already registered');

  const hashed = await bcrypt.hash(data.password, 10);

  await userRepo.createUser({
    username: data.username,
    email: data.email,
    password: hashed,
    profile_photo_path: data.profile_photo_path || null
  });
};

exports.login = async (email, password) => {
  const user = await userRepo.findByEmail(email);
  if (!user) throw new Error('Invalid credentials');

  const match = await bcrypt.compare(password, user.password);
  if (!match) throw new Error('Invalid credentials');

  return user;
};
