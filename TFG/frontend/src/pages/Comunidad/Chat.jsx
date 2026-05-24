import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import api from "../../api";
import "./Chat.css";

export default function Chat() {
    const { id } = useParams();

    const [mensajes, setMensajes] = useState([]);
    const [mensaje, setMensaje] = useState("");
    const [loading, setLoading] = useState(true);
    const [usuario, setUsuario] = useState(null);
    const user = JSON.parse(localStorage.getItem("user"));
    const MY_ID = user?.id;
    useEffect(() => {
        cargarChat();
        cargarUsuario();
    }, [id]);

    const cargarChat = async () => {
        try {
            const response = await api.get(`/mensajes/${id}`);
            setMensajes(response.data?.data || []);
        } catch (error) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    const cargarUsuario = async () => {
        try {
            const response = await api.get(`/usuario/${id}`);
            setUsuario(response.data.data.usuario);
        } catch (error) {
            console.log(error);
        }
    };

    const enviarMensaje = async (e) => {
        e.preventDefault();

        if (!mensaje.trim()) return;

        try {
            const response = await api.post(`/mensajes/${id}`, {
                contenido: mensaje
            });

            setMensajes((prev) => [...prev, response.data?.data]);
            setMensaje("");

        } catch (error) {
            console.log(error);
        }
    };

    if (loading) return <div>Cargando chat...</div>;

    return (
        <div className="chat-container">

            <h2 className="chat-header"> {usuario?.name || "Chat"}</h2>

            <div className="chat-box">
                {mensajes.length === 0 && (
                    <p>No hay mensajes aún</p>
                )}

                {mensajes.map((m) => {
                    const soyYo = m.emisor_id === MY_ID;

                    return (
                        <div
                            key={m.id}
                            className={`mensaje ${soyYo ? "mio" : ""}`}
                        >
                            <strong>
                                {soyYo ? "Yo" : m.emisor?.name}
                            </strong>

                            <p>{m.contenido}</p>
                        </div>
                    );
                })}
            </div>

            <form onSubmit={enviarMensaje} className="chat-form">
                <input
                    value={mensaje}
                    onChange={(e) => setMensaje(e.target.value)}
                    placeholder="Escribe un mensaje..."
                />
                <button type="submit">Enviar</button>
            </form>

        </div>
    );
}