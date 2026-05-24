import { useEffect, useState } from "react";
import api from "../../api";
import { useParams, useNavigate } from "react-router-dom";
import "./EditarPublicacion.css";

export default function EditarPublicacion() {
    const { id } = useParams();
    const navigate = useNavigate();

    const [contenido, setContenido] = useState("");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        cargarPublicacion();
    }, [id]);

    const cargarPublicacion = async () => {
        try {
            const response = await api.get(`/publicacion/${id}`);
            setContenido(response.data.data.contenido);
        } catch (error) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    const actualizarPublicacion = async (e) => {
        e.preventDefault();
        if (contenido.trim() === "") return;

        try {
            await api.put(`/publicacion/${id}`, { contenido: contenido });
            navigate(`/comunidad/perfil/${user?.id}`);
        } catch (error) {
            console.log(error);
        }
    };

    if (loading) {
        return <div>Cargando publicación...</div>;
    }

    return (
        <div className="editar-publicacion-container">

            <div className="editar-publicacion-card">

                <h1>Editar Publicación</h1>

                <form onSubmit={actualizarPublicacion} className="editar-publicacion-form">

                    <textarea
                        value={contenido}
                        onChange={(e) => setContenido(e.target.value)}
                    />

                    <button type="submit">
                        Guardar Cambios
                    </button>

                </form>

            </div>

        </div>
    );
}