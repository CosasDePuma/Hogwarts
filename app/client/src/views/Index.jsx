import React, { Component, Fragment } from 'react';

import Header       from './components/Header.jsx';
import ModalAuth    from './components/ModalAuth.jsx';
import Phone        from './components/Phone.jsx';
import Slogan       from './components/Slogan.jsx';
import Logo         from './components/Logo.jsx';
import ModalWindowUpload  from './components/ModalUpload.jsx';

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

            uploadIsOpen: false,
            setUploadIsOpen: (state) => { this.setState({ uploadIsOpen: state }); }
        }
    }

    render() {
        return (
            <Fragment>
                <Header
                    openLogin={this.state.setLoginIsOpen}
                    openRegister={this.state.setRegisterIsOpen} 
                    openUpload={this.state.setUploadIsOpen}
                    openComment={this.state.setCommentIsOpen}/>
                
                <div className="welcome">
                    <Slogan />
                    <Phone />
                </div>
    
                <ModalAuth
                    loginIsOpen={this.state.loginIsOpen} openLogin={this.state.setLoginIsOpen}
                    registerIsOpen={this.state.registerIsOpen} openRegister={this.state.setRegisterIsOpen}
                    />
                <ModalWindowUpload
                     uploadIsOpen={this.state.uploadIsOpen} openUpload={this.state.setUploadIsOpen}
                     />

                <Logo />
            </Fragment>
        );
    }
}
export default Index;