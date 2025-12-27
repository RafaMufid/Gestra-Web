const express = require('express');
const app = express();
require('dotenv').config();
app.use(express.json());

app.use('/api/users', require('./routes/userRoutes'));
app.listen(3000, () => console.log('API running on port 3000'));
module.exports = app;
