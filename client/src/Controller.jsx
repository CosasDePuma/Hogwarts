import React, { Component } from 'react';
import { IntlProvider } from 'react-intl';
import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';

import { language, messages } from './controllers/language.jsx';

import Index from './views/Index.jsx';

class Controller extends Component {
    constructor(props) {
        super(props);

        this.state = {
            locale: { language: language }
        }
    }

    render() {
        return (
            <IntlProvider
                locale={this.state.locale.language}
                messages={messages[this.state.locale.language]}>
                
                <Router>
                    <Switch>
                        <Route path="/" exact component={Index} />
                    </Switch>
                </Router>
            </IntlProvider>
        )
    }
}

export default Controller;
