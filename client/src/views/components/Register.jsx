import React, { Component } from 'react';
import { FormattedMessage as Span } from 'react-intl';

import { defaultLang } from '../../controllers/language';

class Register extends Component {
    render() {
        return(
            <div id="register">
                <h1>
                    <Span id="register" defaultMessage={defaultLang["register"]} />
                </h1>
                
                <form onSubmit={(e) => e.preventDefault() }>
                    <label>
                        <Span id="user" defaultMessage={defaultLang["user"]} />
                    </label>
                    <input name="user" type="text" autocomplete="off" pattern="[A-Za-z0-9_.]{4,20}" />
                    
                    <label>
                        <Span id="email" defaultMessage={defaultLang["email"]} />
                    </label>
                    <input name="email" type="email" autocomplete="off" />
                    
                    <label>
                        <Span id="pass" defaultMessage={defaultLang["pass"]} />
                    </label>
                    <input name="pass" type="password"
                        onFocus={() => { document.querySelector('.animal .cortina').style = "height: 150px" }}
                        onBlur={() => { document.querySelector('.animal .cortina').style = "height: 20px" }}
                        autocomplete="off" />
                    
                    <label>
                        <Span id="repeatpass" defaultMessage={defaultLang["repeatpass"]} />
                    </label>
                    <input name="passchk" type="password"
                        onFocus={() => { document.querySelector('.animal .cortina').style = "height: 150px" }}
                        onBlur={() => { document.querySelector('.animal .cortina').style = "height: 20px" }}
                        autocomplete="off" />

                    <input type="submit" value="Entrar" />
                </form>
            </div>
        );
    }
}

export default Register;