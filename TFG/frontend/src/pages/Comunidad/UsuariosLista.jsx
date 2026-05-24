import { useEffect, useState } from "react";
import api from "../../api";
import { Link } from "react-router-dom";
import "./UsuarioLista.css";

export default function UsuariosLista() {

    const [usuarios, setUsuarios] = useState([]);
    const [seguidores, setSeguidores] = useState({});
    const [loading, setLoading] = useState(null);

    useEffect(() => {
        cargarUsuarios();
        cargarSeguidores();
    }, []);

    const cargarUsuarios = async () => {
        try {
            const response = await api.get("/usuarios");
            setUsuarios(response.data.data);
        } catch (error) {
            console.log(error);
        }
    };

    const cargarSeguidores = async () => {
        try {
            const response = await api.get("/relaciones");

            const mapa = {};

            response.data.data.forEach((relacion) => {
                mapa[relacion.usuario_seguido_id] = relacion;
            });

            setSeguidores(mapa);

        } catch (error) {
            console.log(error);
        }
    };

    const enviarSolicitud = async (id) => {
        try {

            setLoading(id);

            setSeguidores((prev) => ({
                ...prev,
                [id]: { estado: "pendiente" }
            }));

            await api.post(`/usuario/${id}/seguir`);

            await cargarSeguidores();

        } catch (error) {

            console.log(error);

            setSeguidores((prev) => {
                const copia = { ...prev };
                delete copia[id];
                return copia;
            });

        } finally {
            setLoading(null);
        }
    };

    return (
        <div className="usuarios-container">

            <h1>Usuarios</h1>

            <ul className="usuarios-lista">

                {usuarios.map((usuario) => {

                    const estado = seguidores[usuario.id]?.estado;

                    return (
                        <li
                            key={usuario.id}
                            className="usuario-card"
                        >

                            <div className="usuario-info">

                                <div className="usuario-avatar">
                                    {usuario.name?.charAt(0).toUpperCase()}
                                </div>

                                <Link
                                    to={`/comunidad/perfil/${usuario.id}`}
                                    className="usuario-link"
                                >
                                    {usuario.name}
                                </Link>

                            </div>

                            {!estado && (
                                <button
                                    onClick={() => enviarSolicitud(usuario.id)}
                                    disabled={loading === usuario.id}
                                    className="btn-seguir"
                                >
                                    {loading === usuario.id
                                        ? "Enviando..."
                                        : "Seguir"}
                                </button>
                            )}

                            {estado === "pendiente" && (
                                <button
                                    disabled
                                    className="btn-pendiente"
                                >
                                    Solicitud enviada 
                                </button>
                            )}

                            {estado === "aceptado" && (
                                <button
                                    disabled
                                    className="btn-seguido"
                                >
                                    Siguiendo 
                                </button>
                            )}

                        </li>
                    );
                })}

            </ul>

        </div>
    );
}