
import React from 'react';
import './BookForm.css';

const BookForm = ({ bookId, onSave, onCancel }) => {
    return (
        <div className="book-form-overlay">
            <div className="book-form-container">
                <h2>{bookId ? 'Modifier le livre' : 'Ajouter un livre'}</h2>
                <p>Formulaire en cours de développement...</p>
                <div className="form-actions">
                    <button onClick={onCancel} className="btn-cancel">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    );
};

export default BookForm;
