import React, { Component, Fragment } from 'react';

import { isLogged } from '../controllers/authentication.jsx';

import Header       from './components/Header.jsx';
import Phone        from './components/Phone.jsx';

import '../styles/Default.css';
import '../styles/Responsive.css';

class Index extends Component {
    componentDidMount() {
        if(!isLogged()) {
            window.location.href = "/";
        }
    }

    render() {
        return (
            <Fragment>
                <Header />
                <div className="welcome">
                    <div className="slogan">
                        <h1>Lorem Ipsum</h1>
                        <h1>dolor sit amet</h1>
                    </div>
                </div>
            </Fragment>
        );
    }
}

export default Index;