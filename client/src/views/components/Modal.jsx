import React, { Component } from 'react';
import Modal from 'react-modal';
import { CgClose } from 'react-icons/cg';

import Animal   from './Animal.jsx';
import Login    from './Login.jsx';
import Register from './Register.jsx';

import '../../styles/Modal.css';

Modal.setAppElement("#root");

class ModalWindow extends Component {
    render() {
        const close = () => { this.props.openLogin(false); this.props.openRegister(false); }

        return (
            <Modal className="modal" overlayClassName="overlay"
                isOpen={this.props.loginIsOpen || this.props.registerIsOpen }
                onRequestClose={close}>
                
                <div className="close">
                    <CgClose onClick={close} />
                </div>

                <Animal />

                { this.props.loginIsOpen ? <Login /> : <Register /> }
            </Modal>
        );
    }
}

export default ModalWindow;