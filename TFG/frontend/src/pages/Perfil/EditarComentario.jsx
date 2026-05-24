import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import api from "../../api";

export default function EditarComentario() {
    const { id } = useParams();
    const navigate = useNavigate();

    const [contenido, setContenido] = useState("");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        cargarComentario();
    }, [id]);

    const cargarComentario = async () => {
        try{
            const response = await api.get(`/comentario/${id}`);
            setContenido(response.data.data.contenido);
        }catch(error){
            console.log(error);
        }finally{
            setLoading(false);
        }
    };

    const editarComentario = async (e) => {
        e.preventDefault();
        if (contenido.trim() === "") return;

        try {
            await api.put(`/comentario/${id}`, {contenido: contenido});
            navigate(`/comunidad/perfil/${user?.id}`);
        } catch (error) {
            console.log(error);
        }
    };

    if (loading) {
        return <div>Cargando comentario...</div>;
    }

    return (
        <div>
            <h1>Editar comentario</h1>
            <form onSubmit={editarComentario}>
                <textarea value={contenido} onChange={(e) => setContenido(e.target.value)}></textarea>
                <button type="submit">Guardar</button>
            </form>
        </div>
    );
}
