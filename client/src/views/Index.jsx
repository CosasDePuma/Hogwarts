import React, { Component, Fragment } from 'react';

import Header       from './components/Header.jsx';
import ModalWindow  from './components/Modal.jsx';
import Phone        from './components/Phone.jsx';
import Slogan       from './components/Slogan.jsx';

import '../styles/Default.css';
import '../styles/Responsive.css';

class Index extends Component {
    constructor(props) {
        super(props);        
        this.state = {
            loginIsOpen: false,
            setLoginIsOpen: (state) => { this.setState({ loginIsOpen: state }); },

            registerIsOpen: false,
            setRegisterIsOpen: (state) => { this.setState({ registerIsOpen: state }); },
        }
    }

    render() {
        return (
            <Fragment>
                <Header
                    openLogin={this.state.setLoginIsOpen}
                    openRegister={this.state.setRegisterIsOpen} />

                <div className="welcome">
                    <Slogan />
                    <Phone />
                </div>
    
                <ModalWindow
                    loginIsOpen={this.state.loginIsOpen} openLogin={this.state.setLoginIsOpen}
                    registerIsOpen={this.state.registerIsOpen} openRegister={this.state.setRegisterIsOpen} />
            </Fragment>
        );
    }
}

export default Index;