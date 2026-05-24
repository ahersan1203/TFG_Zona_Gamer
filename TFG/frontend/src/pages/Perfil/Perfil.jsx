import{useEffect, useState} from "react";
import api from "../../api";

export default function Perfil(){
    const [user, setUser] = useState(null);
    const [publicaciones, setPublicaciones] = useState([]);
    const [comentarios, setComentarios] = useState([]);
    const [loading , setLoading] = useState(true);

    useEffect(() => {
        cargarPerfil();
    }, []);

    const cargarPerfil = async () => {
        try{
            const response = await api.get("/perfil");
            setUser(response.data.user);
            setPublicaciones(response.data.publicaciones);
            setComentarios(response.data.comentarios);
        }catch(error){
            console.log(error);
        }finally{
            setLoading(false);
        }
    };
    if(loading) {
        return <div>Cargando perfil...</div>;
    }
    if(!user) {
        return <div>No hay perfil</div>;
    }
    return(
        <div>
            <div>
                <h1>{user.name}</h1>
                <p>{user.email}</p>
                <h2>Publicaciones</h2>
                {user.rol_id === 1 && (
                    <div>
                        <a href="/admin">
                            <button>🛡 Administrar</button>
                        </a>
                    </div>
                )}
            </div>
            <hr />
            <div>
                <h2>Mis Publicaciones</h2>
                {publicaciones.length === 0 && (
                    <p>No hay publicaciones</p>
                )}
                {publicaciones.map((publicacion) => (
                    <div key={publicacion.id}>
                        <p>{publicacion.contenido}</p>
                    </div>
                ))}
            </div>
            <hr />
                <h2>Mis Comentarios</h2>
                {comentarios.length === 0 && (
                    <p>No hay comentarios</p>
                )}
                {comentarios.map((comentario) => (
                    <div key={comentario.id}>
                        <p>{comentario.contenido}</p>
                    </div>
                ))}
            <hr />
                <div>
                    <a href="/perfil/configuracion">
                        <button>🛠 Configuracion</button>
                    </a>
                </div>
        </div>
    )
}