import React, { Component } from 'react';

import Video from './Video.jsx';

import '../../styles/Timeline.css';

class Timeline extends Component {
    render() {
        return (
            <div className="timeline">
                <Video user="script-kitty" src="/v/ac06aab1a6e0bfcd5f2056e9fa4706e9.mp4" />
                <Video user="bugsbunny" src="/v/57a01cc5bd2e7218e42a113a2e14430a.mp4" />
            </div>
        );
    }
}

export default Timeline;