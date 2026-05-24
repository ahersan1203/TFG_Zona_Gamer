import { useEffect, useState } from "react";
import api from "../../api";
import { Link } from "react-router-dom";
import "./AdminPanel.css";

export default function AdminPanel() {

    const [section, setSection] = useState("comunidad");

    const [data, setData] = useState({
        comunidad: [],
        eventos: [],
        noticias: [],
        usuarios: []
    });

    const [loading, setLoading] = useState(true);

    useEffect(() => {
        cargarDatos();
    }, []);

    const cargarDatos = async () => {
        try {
            const response = await api.get("/admin");

            setData({
                comunidad: response.data.publicaciones || [],
                eventos: response.data.eventos || [],
                noticias: response.data.noticias || [],
                usuarios: response.data.usuarios || []
            });

        } catch (error) {
            console.log("Error admin:", error);
        } finally {
            setLoading(false);
        }
    };

    const eliminarEvento = async (id) => {
        if (!window.confirm("¿Eliminar evento?")) return;

        await api.delete(`/eventos/${id}`);

        setData(prev => ({
            ...prev,
            eventos: prev.eventos.filter(e => e.id !== id)
        }));
    };

    const eliminarNoticia = async (id) => {
        if (!window.confirm("¿Eliminar noticia?")) return;

        await api.delete(`/noticias/${id}`);

        setData(prev => ({
            ...prev,
            noticias: prev.noticias.filter(n => n.id !== id)
        }));
    };
    const eliminarUsuario = async (id) => {

        if (!window.confirm("¿Eliminar usuario?")) return;

        try {

            await api.delete(`/usuarios/${id}`);

            setData(prev => ({
                ...prev,
                usuarios: prev.usuarios.filter(u => u.id !== id)
            }));

        } catch (error) {
            console.log(error);
        }
    };

    if (loading) return <div>Cargando...</div>;

    return (
        <div className="admin-container">

            <h1>Panel de Administración</h1>

            <div className="admin-tabs">
                <button onClick={() => setSection("comunidad")} className={section === "comunidad" ? "active" : ""}>
                    Comunidad
                </button>

                <button onClick={() => setSection("eventos")} className={section === "eventos" ? "active" : ""}>
                    Eventos
                </button>

                <button onClick={() => setSection("noticias")} className={section === "noticias" ? "active" : ""}>
                    Noticias
                </button>

                <button onClick={() => setSection("usuarios")} className={section === "usuarios" ? "active" : ""}>
                    Usuarios
                </button>
            </div>

            <hr />

            {section === "eventos" && (
                <div className="admin-section">
                    <h2>Eventos</h2>

                    {data.eventos.map((evento) => (
                        <div key={evento.id} className="admin-card">

                            <h3>{evento.titulo}</h3>
                            <p>{evento.descripcion}</p>

                            <div className="admin-actions">

                                <Link to={`/eventos/${evento.id}/editar`} className="btn-link">
                                    <button className="btn-edit">Editar</button>
                                </Link>

                                <button className="btn-delete" onClick={() => eliminarEvento(evento.id)}>
                                    Eliminar
                                </button>

                            </div>

                        </div>
                    ))}
                </div>
            )}

            {section === "noticias" && (
                <div className="admin-section">
                    <h2>Noticias</h2>

                    {data.noticias.map((noticia) => (
                        <div key={noticia.id} className="admin-card">

                            <h3>{noticia.titulo}</h3>
                            <p>{noticia.contenido}</p>

                            <div className="admin-actions">

                                <Link to={`/noticias/${noticia.id}/edit`} className="btn-link">
                                    <button className="btn-edit">Editar</button>
                                </Link>

                                <button className="btn-delete" onClick={() => eliminarNoticia(noticia.id)}>
                                    Eliminar
                                </button>

                            </div>

                        </div>
                    ))}
                </div>
            )}

            {section === "comunidad" && (
                <div className="admin-section">
                    <h2>Publicaciones</h2>

                    {data.comunidad.map((publicacion) => (
                        <div key={publicacion.id} className="admin-card">

                            <p>{publicacion.contenido}</p>

                            <div className="admin-actions">

                                <button
                                    className="btn-delete"
                                    onClick={async () => {
                                        if (!window.confirm("¿Eliminar publicación?")) return;

                                        await api.delete(`/publicacion/${publicacion.id}`);

                                        setData(prev => ({
                                            ...prev,
                                            comunidad: prev.comunidad.filter(p => p.id !== publicacion.id)
                                        }));
                                    }}
                                >
                                    Eliminar
                                </button>

                            </div>

                        </div>
                    ))}
                </div>
            )}
            {section === "usuarios" && (
            <div className="admin-section">

                <h2>Usuarios</h2>

                {data.usuarios.map((usuario) => (

                    <div key={usuario.id} className="admin-card">

                        <h3>{usuario.nombre}</h3>

                        <p>{usuario.email}</p>

                        <p>Rol: {usuario.rol_id}</p>

                        <div className="admin-actions">

                            <Link
                                to={`/admin/usuarios/${usuario.id}/editar`}
                                className="btn-link"
                            >
                                <button className="btn-edit">
                                    Editar
                                </button>
                            </Link>

                            <button
                                className="btn-delete"
                                onClick={() => eliminarUsuario(usuario.id)}
                            >
                                Eliminar
                            </button>

                        </div>

                    </div>

                ))}

            </div>
        )}

        </div>
    );
}