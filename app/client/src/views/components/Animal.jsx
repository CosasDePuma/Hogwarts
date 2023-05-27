import React, { Component } from 'react';

import '../../styles/Animal.css';

class Animal extends Component {
    render() {
        return (
            <div className="animal">
                <img className="bear" src="/img/bear.png" alt="Osito!" />
                <div className="cortina"></div>
            </div>
        );
    }
}

export default Animal;