import { useState } from "react";
import api from "../../api";

export default function AdminEventos({ eventos, recargar }) {

    const [loading, setLoading] = useState(null);

    const eliminarEvento = async (id) => {
        if (!window.confirm("¿Eliminar evento?")) return;

        try {
            setLoading(id);
            await api.delete(`/eventos/${id}`);

            recargar();
        } catch (error) {
            console.log(error);
        } finally {
            setLoading(null);
        }
    };

    const editarEvento = async (id, data) => {
        try {
            await api.put(`/eventos/${id}`, data);
            recargar();
        } catch (error) {
            console.log(error);
        }
    };

    if (eventos.length === 0) {
        return <p>No hay eventos</p>;
    }

    return (
        <div className="admin-list">

            <h2>Gestión de Eventos</h2>

            {eventos.map((evento) => (

                <div key={evento.id} className="admin-card">

                    <h3>{evento.titulo}</h3>
                    <p>{evento.descripcion}</p>

                    <button
                        onClick={() =>
                            editarEvento(evento.id, {
                                titulo: evento.titulo,
                                descripcion: evento.descripcion
                            })
                        }
                    >
                        Editar
                    </button>

                    <button
                        onClick={() => eliminarEvento(evento.id)}
                        disabled={loading === evento.id}
                    >
                        {loading === evento.id ? "Eliminando..." : "🗑 Eliminar"}
                    </button>

                </div>

            ))}

        </div>
    );
}