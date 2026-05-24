import { useEffect, useState } from "react";
import api from "../../api";
import { Link, useNavigate } from "react-router-dom";

import FullCalendar from "@fullcalendar/react";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

import esLocale from "@fullcalendar/core/locales/es";

import "./Eventos.css";

export default function Eventos() {
    const navigate = useNavigate();

    const [eventos, setEventos] = useState([]);
    const [loading, setLoading] = useState(true);

    const user = JSON.parse(localStorage.getItem("user"));

    useEffect(() => {
        cargarEventos();
    }, []);

    const cargarEventos = async () => {
        try {
            const response = await api.get("/eventos");

            const eventosFiltrados = response.data.map((evento) => ({
                id: evento.id,
                title: evento.nombre,
                start: evento.fecha_inicio,
                end: evento.fecha_final
            }));

            setEventos(eventosFiltrados);

        } catch (error) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    if (loading) {
        return (
            <div className="eventos-loading">
                Cargando eventos...
            </div>
        );
    }

    return (
        <div className="eventos-container">

            <div className="eventos-header">
                <h1>Eventos</h1>

                {user?.rol_id == 1 && (
                    <Link to="/eventos/crear">
                        <button className="btn-crear-evento">
                            + Crear Evento
                        </button>
                    </Link>
                )}
            </div>

            <div className="eventos-calendar-card">
                <FullCalendar
                    plugins={[dayGridPlugin, interactionPlugin]}
                    initialView="dayGridMonth"
                    locale={esLocale}
                    height="auto"
                    events={eventos}
                    selectable={true}
                    selectMirror={true}
                    dayMaxEvents={true}
                    buttonText={{
                        today: "Hoy",
                        month: "Mes",
                        week: "Semana",
                        day: "Día",
                        list: "Lista"
                    }}
                    eventClick={(info) => {
                        navigate(`/eventos/${info.event.id}`);
                    }}
                />
            </div>

        </div>
    );
}