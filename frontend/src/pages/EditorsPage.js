import React, { useState, useEffect } from "react";
import { editorService } from "../services/api";
import EditorCard from "../components/editors/EditorCard";
import EditorForm from "../components/editors/EditorForm";
import "./EditorsPage.css";

const EditorsPage = () => {
  const [editors, setEditors] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showForm, setShowForm] = useState(false);
  const [editingEditor, setEditingEditor] = useState(null);

  useEffect(() => {
    fetchEditors();
  }, []);

  const fetchEditors = async () => {
    try {
      setLoading(true);
      const data = await editorService.getAll();
      setEditors(data);
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  const handleAddEditor = () => {
    setEditingEditor(null);
    setShowForm(true);
  };

  const handleEditEditor = (editor) => {
    setEditingEditor(editor);
    setShowForm(true);
  };

  const handleDeleteEditor = async (id) => {
    if (window.confirm("Êtes-vous sûr de vouloir supprimer cet éditeur ?")) {
      try {
        await editorService.delete(id);
        fetchEditors();
      } catch (err) {
        setError(err.message);
      }
    }
  };

  const handleSaveEditor = async (editorData) => {
    try {
      if (editingEditor) {
        await editorService.update(editingEditor.id, editorData);
      } else {
        await editorService.create(editorData);
      }
      setShowForm(false);
      setEditingEditor(null);
      fetchEditors();
    } catch (err) {
      setError(err.message);
    }
  };

  const handleCancelForm = () => {
    setShowForm(false);
    setEditingEditor(null);
  };

  if (loading) {
    return (
      <div className="editors-page">
        <div className="container">
          <h1>Éditeurs</h1>
          <div className="loading">Chargement en cours...</div>
        </div>
      </div>
    );
  }

  if (error) {
    return (
      <div className="editors-page">
        <div className="container">
          <h1>Éditeurs</h1>
          <div className="error">Erreur: {error}</div>
        </div>
      </div>
    );
  }

  return (
    <div className="editors-page">
      <div className="container">
        <div className="page-header">
          <h1>📚 Éditeurs</h1>
          <p className="page-description">
            Découvrez tous les éditeurs de notre collection de livres.
          </p>
          <button className="btn-add-editor" onClick={handleAddEditor}>
            ➕ Ajouter un éditeur
          </button>
        </div>

        {editors.length === 0 ? (
          <div className="no-editors">
            <p>Aucun éditeur trouvé.</p>
          </div>
        ) : (
          <div className="editors-grid">
            {editors.map((editor) => (
              <EditorCard
                key={editor.id}
                editor={editor}
                onEdit={handleEditEditor}
                onDelete={handleDeleteEditor}
              />
            ))}
          </div>
        )}

        {showForm && (
          <EditorForm
            editor={editingEditor}
            onSave={handleSaveEditor}
            onCancel={handleCancelForm}
          />
        )}
      </div>
    </div>
  );
};

export default EditorsPage;
