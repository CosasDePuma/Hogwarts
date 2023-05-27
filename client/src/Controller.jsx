import React, { Component } from 'react';
import { IntlProvider } from 'react-intl';
import { BrowserRouter as Router, Switch, Route } from 'react-router-dom';

import { language, messages } from './controllers/language.jsx';
import { ProtectedRoute } from './controllers/authentication.jsx';

import Index from './views/Index.jsx';
import Home from './views/Home.jsx';
import Logo from './views/components/Logo.jsx';

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
                        <ProtectedRoute path="/home" exact component={Home} />
                    </Switch>

                    <Logo />
                </Router>
            </IntlProvider>
        )
    }
}

export default Controller;
