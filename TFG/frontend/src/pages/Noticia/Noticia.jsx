import { useEffect, useState } from "react";
import api from "../../api";
import { Link } from "react-router-dom";
import "./Noticia.css";

export default function Noticias() {
    const [noticias, setNoticias] = useState([]);
    const [categorias, setCategorias] = useState([]);
    const [categoriaId, setCategoriaId] = useState("");
    const [loading, setLoading] = useState(true);

    const user = JSON.parse(localStorage.getItem("user") || "null");

    useEffect(() => {
        cargarDatos();
    }, [categoriaId]);

    const cargarDatos = async () => {
        setLoading(true);

        try {
            const [noticiasResponse, categoriasResponse] = await Promise.all([
                api.get("/noticias", {
                    params: {
                        categoria_id: categoriaId || null
                    }
                }),
                api.get("/categorias")
            ]);

            setNoticias(noticiasResponse.data.data || []);
            setCategorias(categoriasResponse.data || []);
        } catch (error) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    const eliminarNoticia = async (id) => {
        const confirmar = window.confirm("¿Desea eliminar la noticia?");
        if (!confirmar) return;

        try {
            await api.delete(`/noticias/${id}`);
            cargarDatos();
        } catch (error) {
            console.log(error);
        }
    };

    if (loading) {
        return <p className="noticias-empty">Cargando...</p>;
    }

    return (
        <div className="noticias-container">

            <h1>Noticias</h1>

            <div className="noticias-toolbar">

                {user?.rol_id === 1 && (
                    <Link className="noticias-create-btn" to="/noticias/crear">
                        ➕ Crear noticia
                    </Link>
                )}

                <div className="noticias-filter">
                    <label>Filtrar:</label>

                    <select
                        value={categoriaId}
                        onChange={(e) => setCategoriaId(e.target.value)}
                    >
                        <option value="">Todas</option>

                        {categorias.map((categoria) => (
                            <option key={categoria.id} value={categoria.id}>
                                {categoria.nombre}
                            </option>
                        ))}
                    </select>
                </div>

            </div>

            <div className="noticias-list">

                {noticias.length === 0 ? (
                    <p className="noticias-empty">
                        No hay noticias disponibles.
                    </p>
                ) : (
                    noticias.map((noticia) => (
                        <div key={noticia.id} className="noticia-card">

                            <h3 className="noticia-title">
                                <Link to={`/noticias/${noticia.id}`}>
                                    {noticia.titulo}
                                </Link>
                            </h3>

                            {noticia.imagen_url && (
                                <img
                                    className="noticia-img"
                                    src={noticia.imagen_url}
                                    alt={noticia.titulo}
                                />
                            )}

                            <p>{noticia.contenido}</p>

                            <p className="noticia-meta">
                                <strong>Categoría:</strong>{" "}
                                {noticia.categoria?.nombre || "Sin categoría"}
                            </p>

                            <p className="noticia-meta">
                                <strong>Autor:</strong>{" "}
                                {noticia.usuario?.name || "Desconocido"}
                            </p>

                            

                        </div>
                    ))
                )}

            </div>
        </div>
    );
}