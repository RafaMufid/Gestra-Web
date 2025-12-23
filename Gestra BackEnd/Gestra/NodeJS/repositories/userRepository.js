const db = require('../config/database');

exports.findByEmail = async (email) => {
  const [rows] = await db.query(
    'SELECT * FROM user_data WHERE email = ?',
    [email]
  );
  return rows[0];
};

exports.createUser = async (user) => {
  const { username, email, password, profile_photo_path } = user;
  await db.query(
    'INSERT INTO user_data (username, email, password, profile_photo_path) VALUES (?,?,?,?)',
    [username, email, password, profile_photo_path]
  );
};
