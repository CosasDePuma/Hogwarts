import React, { Component } from 'react';
import { FormattedMessage as Span } from 'react-intl';
import { getName, isLogged } from '../../controllers/authentication.jsx';

import { defaultLang } from '../../controllers/language.jsx';

import '../../styles/Slogan.css';

class Slogan extends Component {
    constructor(props) {
        super(props);
        this.state = { name: "" }
    }
    
    componentDidMount() {
        getName().then(name => this.setState({ name: name }));
    }

    render() {
        return (
            <div className="slogan">
                { isLogged()
                ? <>
                    <h1><Span id="slogan.welcome" defaultMessage={defaultLang["slogan.welcome"]} /></h1>
                    <h1><Span id="slogan.latest" defaultMessage={defaultLang["slogan.latest"]} /></h1>
                </>
                : <>
                    <h1><Span id="slogan.first" defaultMessage={defaultLang["slogan.first"]} /></h1>
                    <h1><Span id="slogan.second" defaultMessage={defaultLang["slogan.second"]} /></h1>
                </>
            }
            </div>
        );
    }
}

export default Slogan;