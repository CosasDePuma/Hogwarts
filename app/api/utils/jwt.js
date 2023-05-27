const jwt       = require('jsonwebtoken');

const SECRET = 't$wM0l4Unm0nt=n&n0sL0p4s4m=sg3N14l_12deadbeef';
exports.SECRET = SECRET;

exports.get = id => {
    return jwt.sign({ 'id': id }, SECRET);
}