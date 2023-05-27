import React, { Component } from 'react';
import { FormattedMessage as Span } from 'react-intl';

import { defaultLang, language } from '../../controllers/language.jsx';
import { logIn } from '../../controllers/authentication.jsx';

class Login extends Component {
    constructor(props) {
        super(props);

        this.state = {
            form: { name: "", pass: "" }
        };

        this.handleChange = async (e) => {
            await this.setState({
                form: { ...this.state.form, [e.target.name]: e.target.value }
            });
        };
    }

    render() {
        return(
            <div className="login">
                <h1>
                    <Span id="login" defaultMessage={defaultLang["login"]} />
                </h1>

                <form onSubmit={(e) => e.preventDefault() }>
                    <label>
                        <Span id="user" defaultMessage={defaultLang["user"]} />
                    </label>
                    <input name="name" type="text"
                        onChange={this.handleChange}
                        autoComplete="off"
                        pattern="[A-Za-z0-9_.]{4,20}" />

                    <label>
                        <Span id="pass" defaultMessage={defaultLang["pass"]} />
                    </label>
                    <input name="pass" type="password"
                        onChange={this.handleChange}
                        onFocus={() => { document.querySelector('.animal .cortina').style = "height: 150px" }}
                        onBlur={() => { document.querySelector('.animal .cortina').style = "height: 20px" }}
                        autoComplete="off" />
    
                    <input type="submit" value={language === 'es' ? 'Enviar' : 'Send'} onClick={() => {
                        logIn(this.state.form, () => window.location.href = '/#/home' );
                        this.props.close();   
                    } } />
                </form>
            </div>
        );
    }
}

export default Login;