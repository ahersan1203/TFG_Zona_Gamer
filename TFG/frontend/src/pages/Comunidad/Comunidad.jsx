import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import api from "../../api";
import "./Comunidad.css";

export default function Comunidad() {

    const [publicaciones, setPublicaciones] = useState([]);

    useEffect(() => {
        cargarPublicaciones();
    }, []);

    const cargarPublicaciones = async () => {
        try {
            const response = await api.get("/comunidad");
            setPublicaciones(response.data.data);
        } catch (error) {
            console.log(error);
        }
    };

    const like = async (id) => {
        try {
        const res = await api.post(`/publicacion/${id}/like`);

        setPublicaciones(prev =>
            prev.map(pub =>
                pub.id === id
                    ? {
                        ...pub,
                        liked: res.data.liked,
                        likes_count: res.data.likes_count
                    }
                    : pub
            )
        );

    } catch (error) {
        console.log("LIKE ERROR:", error.response?.data || error);
    } 
    };

    return (
        <div className="comunidad-container">

            <div className="comunidad-header">
                <h1>Comunidad</h1>

                <Link to="/comunidad/crear">
                    <button className="btn-primary">+ Crear publicación</button>
                </Link>
            </div>

            {publicaciones.map((publicacion) => (
                <div key={publicacion.id} className="post-card">

                    <div className="post-user">
                        <strong>{publicacion.usuario?.name}</strong>
                    </div>

                    <p className="post-content">{publicacion.contenido}</p>

                    <div className="post-actions">

                        <button
                            className={publicacion.liked ? "like-btn active" : "like-btn"}
                            onClick={() => like(publicacion.id)}
                        >
                            👍 {publicacion.likes_count || 0}
                        </button>

                        <Link to={`/comunidad/publicacion/${publicacion.id}/comentario`}>
                            <button className="comment-btn">
                                💬 {publicacion.comentarios?.length || 0}
                            </button>
                        </Link>
                    </div>

                    <div className="comments-section">

                        <h4>Comentarios</h4>

                        {(!publicacion.comentarios || publicacion.comentarios.length === 0) && (
                            <p className="no-comments">No hay comentarios</p>
                        )}

                        {publicacion.comentarios?.map((comentario) => (
                            <div key={comentario.id} className="comment">
                                <strong>{comentario.usuario?.name}</strong>
                                <p>{comentario.contenido}</p>
                            </div>
                        ))}
                    </div>

                </div>
            ))}
        </div>
    );
}