const cors      = require('cors');
const express   = require('express');
const fileupload = require('express-fileupload');

// Config
const API_HOST = process.env.API_PORT || '0.0.0.0';
const API_PORT = process.env.API_PORT || 5050;

const app = express();
app.use(cors());
app.use(fileupload);
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Router
const router = express.Router();

// User
const user = require('./routes/user');
router.route('/user')
    .get(user.get)
    .post(user.post);
// Account
const account = require('./routes/account');
router.route('/account')
    .post(account.post);
// Videos
const video = require('./routes/video');
router.route('/video')
    .get(video.get)
    .post(video.post);

router.route('/echo')
    .get((req, res) => res.json(req))
    .post((req, res) => res.json(req))
    .put((req, res) => res.json(req));

// API
app.use('/api/v1', router);
// Videos
app.use('/v', express.static('v'));

// Server
app.listen(API_PORT, API_HOST, () => console.log(`API: http://${API_HOST}:${API_PORT}/ in ${app.settings.env} mode`));
