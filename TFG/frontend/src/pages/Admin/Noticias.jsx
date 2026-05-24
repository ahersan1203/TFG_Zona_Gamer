import { useState } from "react";
import api from "../../api";

export default function AdminNoticias({ noticias = [], recargar }) {

    const [loading, setLoading] = useState(null);

    const eliminarNoticia = async (id) => {
        if (!window.confirm("¿Eliminar noticia?")) return;

        try {
            setLoading(id);
            await api.delete(`/noticias/${id}`);

            recargar();
        } catch (error) {
            console.log(error);
        } finally {
            setLoading(null);
        }
    };

    const editarNoticia = async (id, data) => {
        try {
            await api.put(`/noticias/${id}`, data);
            recargar();
        } catch (error) {
            console.log(error);
        }
    };

    if (noticias.length === 0) {
        return <p>No hay noticias</p>;
    }

    return (
        <div className="admin-list">

            <h2>Gestión de Noticias</h2>

            {noticias.map((n) => (

                <div key={n.id} className="admin-card">

                    <h3>{n.titulo}</h3>
                    <p>{n.contenido}</p>

                    {n.imagen && (
                        <img src={n.imagen} alt="" width="150" />
                    )}

                    <small>
                        Categoria: {n.categoria?.nombre || "Sin categoría"}
                    </small>

                    <button
                        onClick={() =>
                            editarNoticia(n.id, {
                                titulo: n.titulo,
                                contenido: n.contenido
                            })
                        }
                    >
                        Editar
                    </button>

                    <button
                        onClick={() => eliminarNoticia(n.id)}
                        disabled={loading === n.id}
                    >
                        {loading === n.id ? "Eliminando..." : "🗑 Eliminar"}
                    </button>

                </div>

            ))}

        </div>
    );
}