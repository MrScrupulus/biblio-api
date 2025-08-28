import React from 'react';
import './LoadingSpinner.css';

const LoadingSpinner = ({ message = "Chargement..." }) => {
    return (
        <div className="loading-container">
            <div className="spinner"></div>
            <p className="loading-message">{message}</p>
        </div>
    );
};

export default LoadingSpinner;
