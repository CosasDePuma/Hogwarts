import React from 'react';
import { Redirect, Route } from 'react-router-dom';
import Cookies from 'universal-cookie';

const cookies = new Cookies();
const options = { path: "/", secure: true };

export function logIn(data, callback) {
    cookies.set('id', '12', options);
    callback();
}

export function logOut(callback) {
    cookies.remove('id', options);
    callback();
}

export function isLogged() {
    const id = cookies.get('id', options);
    return id !== undefined && id !== null;
}

export const ProtectedRoute = ({component: Component, ...rest}) => (
    <Route {...rest} render={(props) => (
        isLogged() ?
            <Component {...rest} {...props} /> :
            <Redirect to="/" /> 
    )} />
)
