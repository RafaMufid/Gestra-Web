const success = (res, statusCode, data) => {
    return res.status(statusCode).json({
        success: true,
        data: data,
    });
};
const error = (res, statusCode, message) => {
    return res.status(statusCode).json({
        success: false,
        message: message,
    });
};
module.exports = {
    success,
    error,
};
