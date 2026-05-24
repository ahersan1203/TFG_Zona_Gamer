import {useState, useEffect} from "react";
import api from "../../api";
import {Link} from "react-router-dom";
import "./Comunidad.css";

export default function AdminComunidad ({publiaciones = [], comentarios = [], recargar}){
    const [loadingPublicaciones, setLoadingPublicaciones] = useState(null);
    const [loadingComentarios, setLoadingComentarios] = useState(null);

    const eliminarPublicacion = async (id) => {
        const confirmar = window.confirm("¿Desea eliminar la publicacion?");
        if (!confirmar) return;

        try {
            setLoadingPublicaciones(id);
            await api.delete(`/publicaciones/${id}`);
            recargar();
        } catch (error) {
            console.log(error);
        } finally {
            setLoadingPublicaciones(null);
        }
    };

    const eliminarComentario = async (id) => {
        const confirmar = window.confirm("¿Desea eliminar el comentario?");
        if (!confirmar) return;

        try {
            setLoadingComentarios(id);
            await api.delete(`/comentarios/${id}`);
            recargar();
        } catch (error) {
            console.log(error);
        } finally {
            setLoadingComentarios(null);
        }
    };
    return (
        <div>
            <h2> Gestión de Comunidad</h2>
            <h3>Publicaciones</h3>
            {publiaciones.map((publicacion) => (
                <div key={publicacion.id} >
                    <p>{publicacion.contenido}</p>
                    <Link to={`/comunidad/publicacion/editar/${publicacion.id}`}>
                        Editar
                    </Link>
                    <button
                        onClick={() => eliminarPublicacion(publicacion.id)}
                        disabled={loadingPublicaciones === publicacion.id}
                    >
                        {loadingPublicaciones === publicacion.id ? (
                            "Eliminando..."
                        ) : (
                            "🗑 Eliminar publicacion"
                        )}
                    </button>
                </div>
            ))}
            <hr/>
            <h3>Comentarios</h3>
            {comentarios.map((comentario) => (
                <div key={comentario.id} >
                    <p>{comentario.contenido}</p>
                    <Link to={`/comunidad/comentario/editar/${comentario.id}`}>
                        Editar
                    </Link>
                    <button
                        onClick={() => eliminarComentario(comentario.id)}
                        disabled={loadingComentarios === comentario.id}
                    >
                        {loadingComentarios === comentario.id ? (
                            "Eliminando..."
                        ) : (
                            "🗑 Eliminar comentario"
                        )}
                    </button>
                </div>
            ))}
        </div>
    );
    
}