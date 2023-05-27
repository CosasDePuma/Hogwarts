import React, { Component } from 'react';

import Timeline     from './Timeline.jsx';
import { isLogged } from '../../controllers/authentication.jsx';

import '../../styles/Phone.css';

class Phone extends Component {
    render() {
        let cover = null;
        if(!isLogged()) {
            cover = <img src="/img/tiktak.svg" alt="TikTak" />;
        }

        return (
            <div className="tiktak">
                <div className={isLogged() ? "mobile up" : "mobile"}>
                    {cover}
                    <div className="glass"></div>
                    <Timeline />
                </div>
            </div>
        );
    }
}

export default Phone;