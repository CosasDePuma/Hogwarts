const hash  = require('hash.js/lib/hash/sha/256');
const jwt   = require('jsonwebtoken');
const path  = require('path');

const { SECRET } = require('../utils/jwt');

const PATH = '../v';

const TABLE = 'videos';
const db = require('../utils/db');
const { sha256 } = require('hash.js');

// GET: Latest videos
// ---------------------------
exports.get = (req, res) => {
    // Query
    const stmt = `SELECT ID, user, title, upload_date, sharedtimes FROM ${TABLE} ORDER BY upload_date DESC`;
    db.query(stmt, [], (err, ok) => {
    if(err) {
        console.log('Error in MySQL');
        res.status(400)
            .json({'err': 'bad request'});
    } else {
        console.log('Videos:', ok);
        res.status(200)
            .json({'videos': ok});
        }
    });
}

// POST: Upload video
// ---------------------------
exports.post = (req, res) => {
    // Check credentials
    const token = req.header('Authorization');
    if(!token || !jwt.verify(token, SECRET))
    {
        console.log('No credentials');
        res.status(401)
        .json({'err': 'unauthorized'});
    } else {
        console.log(req);
        console.log(req.files);
        res.status(201)
            .json({'todo': 'this'});
        // Check values
        /*
        if(!req.files.video || !req.body.title)
        {
            console.log('Bad arguments:', req.body);
            res.status(406)
                .json({'err': 'bad request'});
        } else {
            // Check file
            const targetFile = req.files.video;
            const ext = "." + targetFile.name.split(".").pop()
            if([".mp4", ".webm", ".ogg"].indexOf(ext.toLocaleLowerCase()) == -1
                || ["video/mp4", "video/webm", "video/ogg"].indexOf(targetFile.mimetype) == -1)
            {
                console.log('Bad format:', targetFile);
                res.status(406)
                    .json({'err': 'bad request'});
            } else {
                const id = jwt.decode(token).id;
                const vidID = sha256().update(req.body.video).digest('hex') + ext;
                // Query
                const stmt = `INSERT INTO ${TABLE} (ID, user, title, upload_date) VALUES (${vidID}, ?, ?, ?)`;
                const data = [ id, req.body.title, new Date().toISOString().slice(0, 19).replace('T', ' ') ];
                db.query(stmt, data, (err, ok) => {
                    if(err) {
                        console.log('Error in MySQL:', data);
                        res.status(400)
                            .json({'err': 'bad request'});
                    } else {
                        targetFile.mv(path.join(PATH, vidID), (err) => {
                            if(err) {
                                console.log('Error:', err);
                                res.status(500)
                                    .json({'err': 'try again'});
                            } else {
                                console.log('Video created:', data);
                                res.status(201)
                                    .json({'link': '/v/' + vidID});
                            }
                        });
                    }
                });
            }
        }
           */
    }
}