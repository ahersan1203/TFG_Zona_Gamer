import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import api from "../../api";
import "./Perfil.css";

export default function Perfil() {
    const [user, setUser] = useState(null);
    const [publicaciones, setPublicaciones] = useState([]);
    const [comentarios, setComentarios] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        cargarPerfil();
    }, []);

    const cargarPerfil = async () => {
        try {
            const response = await api.get("/perfil");
            setUser(response.data.user);
            setPublicaciones(response.data.publicaciones);
            setComentarios(response.data.comentarios);
        } catch (error) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    const eliminarPublicacion = async (idPublicacion) => {
        if (!window.confirm("¿Eliminar publicación?")) return;
        try {
            await api.delete(`/publicacion/${idPublicacion}`);
            setPublicaciones(prev => prev.filter(p => p.id !== idPublicacion));
        } catch (error) {
            console.log(error);
        }
    };

    const eliminarComentario = async (idComentario) => {
        if (!window.confirm("¿Eliminar comentario?")) return;
        try {
            await api.delete(`/comentario/${idComentario}`);
            setComentarios(prev => prev.filter(c => c.id !== idComentario));
        } catch (error) {
            console.log(error);
        }
    };

    if (loading) return <div>Cargando perfil...</div>;
    if (!user) return <div>No hay perfil</div>;

    return (
        <div className="perfil-container">

            <div className="perfil-header">
                <h1>{user.name}</h1>
                <p>{user.email}</p>

                <div className="perfil-botones">
                    {user.rol_id === 1 && (
                        <Link to="/admin">
                            <button className="perfil-btn admin-btn">
                                🛡 Administrar
                            </button>
                        </Link>
                    )}
                    <Link to="/perfil/configuracion">
                        <button className="perfil-btn">
                            🛠 Configuración
                        </button>
                    </Link>
                </div>
            </div>

            <div className="perfil-seccion">
                <h2 className="perfil-seccion-titulo">Mis Publicaciones</h2>
                <div className="perfil-lista">
                    {publicaciones.length === 0 ? (
                        <div className="empty-state">No hay publicaciones</div>
                    ) : (
                        publicaciones.map((publicacion) => (
                            <div key={publicacion.id} className="post-card">
                                <p>{publicacion.contenido}</p>
                                <div className="post-actions">
                                    <Link to={`/perfil/editarPublicacion/${publicacion.id}`}>
                                        <button className="edit-btn">Editar</button>
                                    </Link>
                                    <button className="delete-btn" onClick={() => eliminarPublicacion(publicacion.id)}>
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        ))
                    )}
                </div>
            </div>

            <div className="perfil-seccion">
                <h2 className="perfil-seccion-titulo">Mis Comentarios</h2>
                <div className="perfil-lista">
                    {comentarios.length === 0 ? (
                        <div className="empty-state">No hay comentarios</div>
                    ) : (
                        comentarios.map((comentario) => (
                            <div key={comentario.id} className="post-card">
                                <p>{comentario.contenido}</p>
                                <div className="post-actions">
                                    <Link to={`/perfil/editarComentario/${comentario.id}`}>
                                        <button className="edit-btn">Editar</button>
                                    </Link>
                                    <button className="delete-btn" onClick={() => eliminarComentario(comentario.id)}>
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        ))
                    )}
                </div>
            </div>

        </div>
    );
}