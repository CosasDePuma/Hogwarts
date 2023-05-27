import Cookies  from 'universal-cookie';

import { API }  from '../config/config.jsx';

const cookies = new Cookies();
const options = { path: "/", secure: true };
const headers = { 'Accept': 'application/json', 'Content-Type': 'application/json' }

export async function get(method, endpoint, data, auth) {
    let options = { method: method };
    
    if(method !== "GET") {
        options.headers = { ...headers };
        options.body = data !== null ? JSON.stringify(data) : null;
    }
    if(auth !== null) {
        if(options.headers) {
            options.headers['Authorization'] = auth;
        } else {
            options.headers = { 'Authorization': auth }
        }
    }
    const res = await fetch(API + endpoint, options);
    return await res.json();
}

export async function register(data, callback) {
    const body = await get('POST', 'api/v1/user', data, null);
    if(body.token) {
        cookies.set('id', body.token, options, null);
        callback();
    }
}

export async function logIn(data, callback) {
    const body = await get('POST', 'api/v1/account', data, null);
    if(body.token) {
        cookies.set('id', body.token, options, null);
        callback();
    }
}

export function logOut(callback) {
    cookies.remove('id', options);
    callback();
}

export function isLogged() {
    const token = cookies.get('id', options, null);
    return token !== undefined && token !== null;
}

export async function getName() {
    const token = cookies.get('id', options);
    let name = "nobody";
    if(isLogged()) {
        try {
            const body = await get('GET', 'api/v1/user', null, token);
            name = body.username;
        } catch(err) {
            console.log(err);
        }
    }
    return name;
}
