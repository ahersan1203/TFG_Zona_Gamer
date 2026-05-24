import { useEffect, useState } from "react";
import {useNavigate, useParams} from "react-router-dom";
import api from "../../api";
import "./NoticiaShow.css";

export default function NoticiaShow() {
    const [noticia, setNoticia] = useState(null);
    const {id} = useParams();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        cargarNoticia();
    }, [id]);

    const cargarNoticia = async () => {
        try {
            const response = await api.get(`/noticias/${id}`);
            setNoticia(response.data.data);
        } catch (error) {
            console.log(error)
            setError("Error al cargar la noticia");
        } finally {
            setLoading(false);
        }
    };
    if(loading) return <div>Cargando...</div>;
    if (error) return <div>{error}</div>;
    if(!noticia) return <div>Noticia no encontrada</div>;
    return (
        <div className="noticia-show-container">

            <div className="noticia-show-card">

                <h1>{noticia.titulo}</h1>

                {noticia.imagen_url && (
                    <img
                        className="noticia-show-img"
                        src={noticia.imagen_url}
                        alt={noticia.titulo}
                    />
                )}

                <p className="noticia-show-content">
                    {noticia.contenido}
                </p>

                <div className="noticia-show-meta">
                    <p>
                        <strong>Categoría:</strong> {noticia.categoria?.nombre}
                    </p>

                    <p>
                        <strong>Autor:</strong> {noticia.usuario?.name || "Desconocido"}
                    </p>
                </div>

                <div className="noticia-show-actions">
                    <button
                        className="noticia-show-btn"
                        onClick={() => navigate("/noticias")}
                    >
                        Volver
                    </button>
                </div>

            </div>

        </div>
    );
}