import axios from 'axios';
import Cookies  from 'universal-cookie';

import { API } from '../config/config.jsx';

const cookies = new Cookies();
const options = { path: "/", secure: true };

export const upload = (video, title, callback) => {
    let data = new FormData();
    data.append('title', title);
    data.append('video', video, video.name);
    axios.post(API + 'api/v1/video', data, {
        headers: { 'Authorization': cookies.get('id', options) },
        onUploadProgress: e => {
            console.log("Upload progress:", e.loaded / e.total * 100); 
        }
    }).then(res => callback());
}