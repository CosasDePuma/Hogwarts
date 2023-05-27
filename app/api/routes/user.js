const hash = require('hash.js/lib/hash/sha/256');
const validator = require('validator');
const jwt = require('jsonwebtoken');

const { get, SECRET } = require('../utils/jwt');

const TABLE = 'users';
const db = require('../utils/db');

// GET: Info
// ---------------------------
exports.get = (req, res) => {
    // Check values
    const token = req.header('Authorization');
    if(!token || !jwt.verify(token, SECRET))
    {
        console.log('No credentials');
        res.status(401)
            .json({'err': 'unauthorized'});
    } else {
        const id = jwt.decode(token).id;
        // Query
        const stmt = `SELECT username, email FROM ${TABLE} WHERE ID = ?`;
        const data = [ id ];
        db.query(stmt, data, (err, ok) => {
            if(err) {
                console.log('Error in MySQL:', data);
                res.status(400)
                    .json({'err': 'bad request'});
            } else {
                console.log('User:', ok[0]);
                res.status(201)
                    .json(ok[0]);
            }
        });
    }
}

// POST: Register
// ---------------------------
exports.post = (req, res) => {
    // Check values
    if(!req.body.name || !req.body.email || !req.body.pass || !req.body.passchk
        || !validator.isEmail(req.body.email)
        || req.body.pass !== req.body.passchk)
    {
        console.log('Bad arguments:', req.body);
        res.status(406)
            .json({'err': 'bad request'});
        return;
    }
    // Query
    const stmt = `INSERT INTO ${TABLE} (username, email, passwd) VALUES (?, ?, '${hash().update(req.body.pass).digest('hex')}')`;
    const data = [ req.body.name, req.body.email ];
    db.query(stmt, data, (err, ok) => {
        if(err) {
            console.log('Error in MySQL:', data);
            res.status(400)
                .json({'err': 'bad request'});
        } else {
            console.log('User created:', req.body);
            const stmt2 = `SELECT ID FROM ${TABLE} WHERE username = ? AND email = ?`;
            db.query(stmt2, data, (err, ok) => {
                if(err || ok.length == 0) {
                    console.log('Error in MySQL #2:', data);
                    res.status(500)
                        .json({'err': 'bad request'});
                } else {
                    const id = ok[0].ID;
                    res.status(201)
                        .json({ 'token': get(id) });
                }
            });
        }
    });
}