import React, { Component, Fragment } from 'react';
import { FormattedMessage as Span } from 'react-intl';
import { Link } from 'react-router-dom';
import { FaBars } from 'react-icons/fa';
import { CgClose } from 'react-icons/cg';

import { isLogged, logOut } from '../../controllers/authentication.jsx';
import { defaultLang, setLang } from '../../controllers/language.jsx';

import '../../styles/Header.css';

function showMenu() {
    document.querySelector('html').style = "overflow: hidden";
    document.querySelector('header').style = "display: flex";
}

function closeMenu() {
    document.querySelector('html').style = "";
    document.querySelector('header').style = "";
}

class Header extends Component {
    render() {
        return (
            <Fragment>
                <div className="menu" onClick={showMenu}>
                    <FaBars />
                </div>

                <header className="row">
                    <h1>{this.props.name}</h1>
                    <ul>
                        <li>
                            <div className="a" onClick={() => {setLang('es');}}>
                                ES
                            </div>
                        </li>
                        <li>
                            <div className="a" onClick={() => {setLang('en');}}>
                                EN
                            </div>
                        </li>
                    </ul>
                    
                    <ul className="link">
                        <li>
                            <Link to='/#/'>
                                <Span id="header.home" defaultMessage={defaultLang["header.home"]} />
                            </Link>
                        </li>
                        <li>
                            <Link to="/#/trends">
                                <Span id="header.trends" defaultMessage={defaultLang["header.trends"]} />
                            </Link>
                        </li>
                        <li>
                            <Link to="/#/hashtags">
                                <Span id="header.hashtags" defaultMessage={defaultLang["header.hashtags"]} />
                            </Link>
                        </li>
                    </ul>

                    { isLogged() === false ? 
                        <ul className="account">
                            <li><div className="a" onClick={() => this.props.openLogin(true)}>
                                <Span id="login" defaultMessage={defaultLang["login"]} />
                            </div></li>
                            <li><div className="a" onClick={() => this.props.openRegister(true)}>
                                <Span id="register" defaultMessage={defaultLang["register"]} />
                            </div></li>
                           
                        </ul>
                        :
                        <ul className="account">
                            <li>
                                <div className="a" onClick={() => this.props.openUpload(true)}>
                                    <Span id="upload" defaultMessage={defaultLang["upload"]} />
                                </div>
                            </li> 
                            <li>
                                <div className="a" onClick={() => logOut(() => window.location.href = "/#/")}>
                                    <Span id="logout" defaultMessage={defaultLang["logout"]} />
                                </div>
                            </li>
                        </ul>
                    }
        
                    <a onClick={closeMenu}><CgClose /></a>
                </header>
            </Fragment>
        );
    }
}

export default Header;