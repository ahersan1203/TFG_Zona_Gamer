import { useEffect, useState } from "react";
import api from "../../api";
import "./Solicitudes.css";

export default function Solicitudes() {

    const [solicitudes, setSolicitudes] = useState([]);

    useEffect(() => {
        cargarSolicitudes();
    }, []);

    const cargarSolicitudes = async () => {
        try {
            const response = await api.get("/solicitudes");
            setSolicitudes(response.data?.data || []);
        } catch (error) {
            console.error(error);
        }
    };

    const aceptar = async (id) => {
        try {
            await api.post(`/solicitud/${id}/aceptar`);
            cargarSolicitudes();
        } catch (error) {
            console.log(error);
        }
    };

    const rechazar = async (id) => {
        try {
            await api.post(`/solicitud/${id}/rechazar`);
            cargarSolicitudes();
        } catch (error) {
            console.log(error);
        }
    };

    return (
        <div className="solicitudes-container">

            <h1 className="solicitudes-title">
                Solicitudes de amistad
            </h1>

            {solicitudes.length === 0 ? (
                <div className="solicitudes-empty">
                    No hay solicitudes pendientes
                </div>
            ) : (

                <ul className="solicitudes-list">

                    {solicitudes.map((solicitud) => (

                        <li
                            key={solicitud.id}
                            className="solicitud-card"
                        >
                            <div className="solicitud-info">

                                <div className="solicitud-avatar">
                                    {solicitud.usuario?.name?.charAt(0).toUpperCase()}
                                </div>

                                <p className="solicitud-nombre">
                                    {solicitud.usuario?.name}
                                </p>

                            </div>

                            <div className="solicitud-actions">

                                <button
                                    className="btn-aceptar"
                                    onClick={() => aceptar(solicitud.id)}
                                >
                                    ✓ Aceptar
                                </button>

                                <button
                                    className="btn-rechazar"
                                    onClick={() => rechazar(solicitud.id)}
                                >
                                    ✕ Rechazar
                                </button>

                            </div>
                        </li>

                    ))}

                </ul>

            )}

        </div>
    );
}