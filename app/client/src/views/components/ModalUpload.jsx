import React, { Component }         from 'react';
import Modal                        from 'react-modal';
import { CgClose }                  from 'react-icons/cg';
import { FormattedMessage as Span } from 'react-intl';

import { upload } from '../../controllers/upload.jsx';
import { defaultLang, language } from '../../controllers/language.jsx';

import '../../styles/Modal.css';

Modal.setAppElement("#root");

class ModalWindowUpload extends Component {
    constructor(props) {
        super(props);
        this.state = {
            video: null,
            title: ""
        }
    }

    fileSelected = e => {
        this.setState({ video: e.target.files[0] });
    }

    render() {
        const close = () => { this.props.openUpload(false) }

        return (
            <Modal className="modal" overlayClassName="overlay"
                isOpen={this.props.uploadIsOpen}
                onRequestClose={close}>
                
                <div className="close">
                    <CgClose onClick={close} />
                </div>

                <div className="Upload">
                <h1>
                    <Span id="upload" defaultMessage={defaultLang["upload"]} />
                </h1>

                <form onSubmit={(e) => e.preventDefault() }>
                    <label>
                        <Span id="title" defaultMessage={defaultLang["title"]} />
                    </label>
                    <input name="title" type="text"
                        onChange={async (e) => this.setState({ title: e.target.value })}
                        autoComplete="off" pattern="[A-Za-z0-9_.]{4,100}" />

                    <label>
                        <Span id="video" defaultMessage={defaultLang["video"]} />
                    </label>
                    <input name="video" type="file" onChange={this.fileSelected}/>
                  
                    <input type="submit" value={language === 'es' ? 'Enviar' : 'Send'} onClick={() => upload(this.state.video, this.state.title, close)} />
                </form>
            </div>
            </Modal>
        );
    }
}

export default ModalWindowUpload;