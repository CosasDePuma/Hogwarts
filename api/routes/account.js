const hash = require('hash.js/lib/hash/sha/256');

const jwt = require('../utils/jwt');

const TABLE = 'users';
const db = require('../utils/db');

// POST: Login
// ---------------------------
exports.post = (req, res) => {
    // Check values
    if(!req.body.name || !req.body.pass) {
        console.log('Bad arguments:', req.body);
        res.status(406)
            .json({'err': 'bad request'});
        return;
    }
    // Query
    const stmt = `SELECT ID FROM ${TABLE} WHERE username = ? AND passwd = '${hash().update(req.body.pass).digest('hex')}' LIMIT 1`;
    const data = [ req.body.name ];
    db.query(stmt, data, (err, ok) => {
        if(err) {
            console.log('Error in MySQL:', data);
            res.status(500)
                .json({'err': 'server error'});
        } else if(ok.length == 0) {
            console.log('Bad username or password', [ req.body.name, req.body.pass ]);
            res.status(400)
                .json({'err': 'bad request'});
        } else {
            const user = ok[0];
            console.log('User login:', user);
            res.status(200)
                .json({ 'token': jwt.get(user.ID) });
        }
    });
}