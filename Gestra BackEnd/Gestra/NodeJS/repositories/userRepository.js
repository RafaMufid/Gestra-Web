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

exports.findById = async (id) => {
  const [rows] = await db.query(
    'SELECT * FROM user_data WHERE id = ?',
    [id]
  );
  return rows[0];
};

exports.updateUser = async (id, data) => {
  const fields = [];
  const values = [];

  for (const key in data) {
    fields.push(`${key} = ?`);
    values.push(data[key]);
  }

  values.push(id);

  const sql = `UPDATE user_data SET ${fields.join(', ')} WHERE id = ?`;
  await db.query(sql, values);
};

exports.findById = async (id) => {
  const [rows] = await db.query(
    'SELECT * FROM user_data WHERE id = ?',
    [id]
  );
  return rows[0];
};
