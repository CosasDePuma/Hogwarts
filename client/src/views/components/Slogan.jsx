import React, { Component } from 'react';
import { FormattedMessage as Span } from 'react-intl';

import { defaultLang } from '../../controllers/language.jsx';

import '../../styles/Slogan.css';

class Slogan extends Component {
    render() {
        return (
            <div className="slogan">
                <h1><Span id="slogan.first" defaultMessage={defaultLang["slogan.first"]} /></h1>
                <h1><Span id="slogan.second" defaultMessage={defaultLang["slogan.second"]} /></h1>
            </div>
        );
    }
}

export default Slogan;