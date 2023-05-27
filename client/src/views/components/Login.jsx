import React, { Component } from 'react';
import { FormattedMessage as Span } from 'react-intl';

import { defaultLang } from '../../controllers/language.jsx';
import { logIn } from '../../controllers/authentication.jsx';

class Login extends Component {
    constructor(props) {
        super(props);

        this.state = {
            form: { user: "", pass: "" }
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
                    <input name="user" type="text"
                        onChange={this.handleChange}
                        autocomplete="off" pattern="[A-Za-z0-9_.]{4,20}" />

                    <label>
                        <Span id="pass" defaultMessage={defaultLang["pass"]} />
                    </label>
                    <input name="pass" type="password"
                        onChange={this.handleChange}
                        onFocus={() => { document.querySelector('.animal .cortina').style = "height: 150px" }}
                        onBlur={() => { document.querySelector('.animal .cortina').style = "height: 20px" }}
                        autocomplete="off" />
    
                    <input type="submit" value="Entrar" onClick={() => logIn(this.state.form, () => window.location.href = "./home" )} />
                </form>
            </div>
        );
    }
}

export default Login;