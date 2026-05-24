import { useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import api from "../../api";
import "./CrearComentario.css";

export default function CrearComentario() {
    const { id } = useParams();
    const navigate = useNavigate();

    const [contenido, setContenido] = useState("");

    const enviar = async (e) => {
        e.preventDefault();

        if (!contenido.trim()) return;

        try {
             await api.post( `/publicacion/${id}/comentario`,{ contenido },
                {headers: {
                        Authorization: `Bearer ${localStorage.getItem("token")}`
                }});

            navigate("/comunidad");

        } catch (error) {
            console.log(error);
        }
    };

    return (
        <div className="crear-comentario-container">

            <div className="crear-comentario-card">

                <h1>Crear comentario</h1>

                <form
                    onSubmit={enviar}
                    className="crear-comentario-form"
                >
                    <textarea
                        value={contenido}
                        onChange={(e) => setContenido(e.target.value)}
                        placeholder="Escribe tu comentario..."
                        maxLength="255"
                    />

                    <div className="contador">
                        {contenido.length}/255
                    </div>

                    <button type="submit">
                        Publicar comentario
                    </button>

                </form>

            </div>

        </div>
    );
}