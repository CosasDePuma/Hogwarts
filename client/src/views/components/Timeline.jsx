import React, { Component } from 'react';

import Video from './Video.jsx';

import '../../styles/Timeline.css';
import { API } from '../../config/config.jsx';
import { isLogged } from '../../controllers/authentication.jsx';

class Timeline extends Component {
    constructor(props) {
        super(props);
        this.state = {
            videos: [
                { user: "bugsbunny", desc: "conejos dandose #mimos", src: API + "v/ac06aab1a6e0bfcd5f2056e9fa4706e9.mp4" },
                { user: "script-kitty", desc: "#gato jugando con peluche", src: API + "v/57a01cc5bd2e7218e42a113a2e14430a.mp4" }
            ]
        }
    }

    componentDidMount() {
        // TODO: Reload vids
    }

    render() {
        let i = 0;
        let videos = [];
        this.state.videos.forEach(video => {
            videos.push(<Video key={i++} viewonly={!isLogged()} user={video.user} desc={video.desc} src={video.src} />)
        })

        return (
            <div className="timeline">
                {videos}
            </div>
        );
    }
}

export default Timeline;