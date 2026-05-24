import { useEffect, useState } from "react";
import { useParams, Link } from "react-router-dom";
import api from "../../api";
import "./PerfilUsuario.css";

export default function PerfilUsuario() {

    const { id } = useParams();

    const [usuario, setUsuario] = useState(null);
    const [publicaciones, setPublicaciones] = useState([]);
    const [amigos, setAmigos] = useState(false);
    const [loading, setLoading] = useState(true);

    const currentUser = JSON.parse(localStorage.getItem("user"));

    useEffect(() => {
        cargarPerfil();
    }, [id]);

    const cargarPerfil = async () => {
        try {
            const response = await api.get(`/usuario/${id}`);

            setUsuario(response.data.data.usuario);
            setPublicaciones(response.data.data.publicaciones);
            setAmigos(response.data.data.amigos);

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

            setPublicaciones(prev =>
                prev.filter(p => p.id !== idPublicacion)
            );

        } catch (error) {
            console.log(error);
        }
    };

    if (loading) return <p>Cargando perfil...</p>;
    if (!usuario) return <p>Usuario no encontrado</p>;

    const esMiPerfil = currentUser?.id === usuario.id;
    const esAdmin = currentUser?.rol_id === 1;

    return (
        <div className="perfil-usuario-container">

            <div className="perfil-header">
                <h1>{usuario.name}</h1>

                <div className="perfil-botones">

                    {!esMiPerfil && amigos && (
                        <Link to={`/comunidad/chat/${usuario.id}`}>
                            <button className="perfil-btn">
                                💬 Mensaje privado
                            </button>
                        </Link>
                    )}

                    {esAdmin && esMiPerfil && (
                        <Link to="/admin">
                            <button className="perfil-btn admin-btn">
                                Administrar
                            </button>
                        </Link>
                    )}

                    {esMiPerfil && (
                        <Link to="/perfil/configuracion">
                            <button className="perfil-btn">
                                Configuración
                            </button>
                        </Link>
                    )}

                </div>
            </div>

            <h2 className="perfil-publicaciones-titulo">
                Publicaciones
            </h2>

            <div className="perfil-publicaciones">

                {publicaciones.length === 0 ? (
                    <div className="empty-state">
                        No hay publicaciones
                    </div>
                ) : (

                    publicaciones.map((publicacion) => (
                        <div key={publicacion.id} className="post-card">

                            <p>{publicacion.contenido}</p>

                            {esMiPerfil && (
                                <div className="post-actions">

                                    <Link to={`/perfil/editarPublicacion/${publicacion.id}`}>
                                        <button className="edit-btn">
                                            Editar
                                        </button>
                                    </Link>

                                    <button
                                        className="delete-btn"
                                        onClick={() => eliminarPublicacion(publicacion.id)}
                                    >
                                        Eliminar
                                    </button>

                                </div>
                            )}

                        </div>
                    ))

                )}

            </div>

        </div>
    );
}