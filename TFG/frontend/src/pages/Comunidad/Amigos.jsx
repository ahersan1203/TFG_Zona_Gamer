import { useEffect, useState } from "react";
import api from "../../api";
import { Link } from "react-router-dom";
import "./Amigos.css";

export default function Amigos() {

    const [amigos, setAmigos] = useState([]);

    const user = JSON.parse(localStorage.getItem("user"));

    useEffect(() => {
        cargarAmigos();
    }, []);

    const cargarAmigos = async () => {
        const response = await api.get("/amigos");
        setAmigos(response.data.data);
    };

    const vistos = new Set();

    return (
        <div className="amigos-container">

            <h1 className="amigos-title">
                Mis amigos
            </h1>

            {amigos.length === 0 ? (
                <div className="no-amigos">
                    No tienes amigos todavía.
                </div>
            ) : (
                <ul className="amigos-list">

                    {amigos.map((relacion) => {

                        const amigo =
                            relacion.usuario_id === user.id
                                ? relacion.seguido
                                : relacion.usuario;

                        if (!amigo) return null;
                        if (vistos.has(amigo.id)) return null;

                        vistos.add(amigo.id);

                        return (
                            <li
                                key={relacion.id}
                                className="amigo-card"
                            >
                                <div className="amigo-info">

                                    <div className="amigo-avatar">
                                        {amigo.name?.charAt(0).toUpperCase()}
                                    </div>

                                    <Link
                                        to={`/comunidad/perfil/${amigo.id}`}
                                        className="amigo-link"
                                    >
                                        {amigo.name}
                                    </Link>

                                </div>

                                <Link
                                    to={`/comunidad/chat/${amigo.id}`}
                                    className="amigo-btn"
                                >
                                    💬 Mensaje
                                </Link>
                            </li>
                        );
                    })}

                </ul>
            )}

        </div>
    );
}