import React, { StrictMode } from 'react';
import ReactDom from 'react-dom';

import Controller from './Controller.jsx'

// Loading color
document.querySelector('body').style = "background-color: #00a19a";

ReactDom.render(
    <StrictMode>
        <Controller />
    </StrictMode>,
    
    document.getElementById('root')
);