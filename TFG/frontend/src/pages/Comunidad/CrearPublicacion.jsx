import { useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../../api";
import "./CrearPublicacion.css";

export default function CrearPublicacion() {
    const [contenido, setContenido] = useState("");

    const navigate = useNavigate();

    const enviarPublicacion = async (e) => {
        e.preventDefault();

        if (contenido.trim() === "") return;

        try {
            await api.post("/publicacion", {
                contenido: contenido
            });

            setContenido("");
            navigate("/comunidad");

        } catch (error) {
            console.log(error);
        }
    };

    return (
        <div className="crear-publicacion-container">

            <div className="crear-publicacion-card">

                <h1>Crear publicación</h1>

                <form
                    onSubmit={enviarPublicacion}
                    className="crear-publicacion-form"
                >
                    <textarea
                        value={contenido}
                        onChange={(e) => setContenido(e.target.value)}
                        placeholder="¿Qué estás pensando?"
                        maxLength="255"
                    />

                    <div className="contador">
                        {contenido.length}/255
                    </div>

                    <button type="submit">
                        Publicar
                    </button>

                </form>

            </div>

        </div>
    );
}