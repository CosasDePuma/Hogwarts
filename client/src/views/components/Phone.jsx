import React, { Component } from 'react';

import Timeline from './Timeline.jsx';

import '../../styles/Phone.css';

class Phone extends Component {
    render() {
        return (
            <div className="tiktak">
                <div className="mobile">
                    <img src="/img/tiktak.svg" alt="TikTak" />
                    <div className="glass"></div>

                    <Timeline />
                </div>
            </div>
        );
    }
}

export default Phone;