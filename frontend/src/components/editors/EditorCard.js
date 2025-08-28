import React from 'react';
import './EditorCard.css';

const EditorCard = ({ editor, onDelete, onEdit }) => {
    const formatDate = (dateString) => {
        if (!dateString) return 'Date inconnue';
        try {
            return new Date(dateString).toLocaleDateString('fr-FR');
        } catch (error) {
            return 'Date invalide';
        }
    };

    return (
        <div className="editor-card">
            <div className="editor-header">
                <div className="editor-icon">📚</div>
                <h3 className="editor-name">{editor.name}</h3>
            </div>
            
            <div className="editor-info">
                <p className="editor-creation-date">
                    <strong>Créé le:</strong> {formatDate(editor.creationDate)}
                </p>
                <p className="editor-head-office">
                    <strong>Siège social:</strong> {editor.headOffice}
                </p>
                <p className="editor-books-count">
                    <strong>Livres publiés:</strong> {editor.books ? editor.books.length : 0}
                </p>
            </div>
            
            <div className="editor-actions">
                <button className="btn btn-edit" onClick={() => onEdit(editor)}>
                    ✏ Modifier
                </button>
                <button
                    className="btn btn-delete"
                    onClick={() => onDelete(editor.id)}
                >
                    🗑 Supprimer
                </button>
            </div>
        </div>
    );
};

export default EditorCard;
