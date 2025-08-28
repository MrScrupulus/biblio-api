import React, { useState, useEffect } from "react";
import "./EditorForm.css";

const EditorForm = ({ editor, onSave, onCancel }) => {
  const [formData, setFormData] = useState({
    name: "",
    creationDate: "",
    headOffice: "",
  });

  useEffect(() => {
    if (editor) {
      setFormData({
        name: editor.name || "",
        creationDate: editor.creationDate
          ? editor.creationDate.split("T")[0]
          : "",
        headOffice: editor.headOffice || "",
      });
    }
  }, [editor]);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    if (
      !formData.name.trim() ||
      !formData.creationDate ||
      !formData.headOffice.trim()
    ) {
      alert("Veuillez remplir tous les champs obligatoires");
      return;
    }

    const editorData = {
      ...formData,
      creationDate: formData.creationDate,
    };

    onSave(editorData);
  };

  return (
    <div className="editor-form-overlay">
      <div className="editor-form-container">
        <h2>{editor ? "Modifier l'éditeur" : "Ajouter un éditeur"}</h2>

        <form onSubmit={handleSubmit} className="editor-form">
          <div className="form-group">
            <label htmlFor="name">Nom de l'éditeur *</label>
            <input
              type="text"
              id="name"
              name="name"
              value={formData.name}
              onChange={handleChange}
              placeholder="Ex: Gallimard"
              required
            />
          </div>

          <div className="form-group">
            <label htmlFor="creationDate">Date de création *</label>
            <input
              type="date"
              id="creationDate"
              name="creationDate"
              value={formData.creationDate}
              onChange={handleChange}
              required
            />
          </div>

          <div className="form-group">
            <label htmlFor="headOffice">Siège social *</label>
            <input
              type="text"
              id="headOffice"
              name="headOffice"
              value={formData.headOffice}
              onChange={handleChange}
              placeholder="Ex: 5 rue Sébastien-Bottin, 75007 Paris"
              required
            />
          </div>

          <div className="form-actions">
            <button type="button" onClick={onCancel} className="btn-cancel">
              Annuler
            </button>
            <button type="submit" className="btn-save">
              {editor ? "Modifier" : "Créer"}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EditorForm;
