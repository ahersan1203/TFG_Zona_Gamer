import {useEffect, useState} from "react";
import api from "../../api";
import {Link, useParams, useNavigate} from "react-router-dom";
import "./EventoShow.css";

export default function EventoShow() {
    const {id} = useParams();
    const navigate = useNavigate();

    const [evento, setEvento] = useState(null);
    const [loading, setLoading] = useState(true);
    const user = JSON.parse(localStorage.getItem('user') || "null");

    useEffect(() => {
        cargarEvento();
    }, [id]);


    const cargarEvento = async () => {
        try {
            const response = await api.get(`/eventos/${id}`);
            setEvento(response.data);
        } catch (error) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    const eliminarEvento = async () =>{
        const confirmar = window.confirm("¿Desea eliminar el evento?");
        if (!confirmar) return;

        try {
            await api.delete(`/eventos/${id}`);
            navigate('/eventos');
        } catch (error) {
            console.log(error);
        }
    };

    if (loading) {
        return <div>Cargando...</div>;
    }

    if (!evento) {
        return <div>No hay evento</div>;
    }

    return (
        <div className="evento-show-container">
    <div className="evento-show-card">

        <h2 className="evento-show-title">{evento.nombre}</h2>

        <p className="evento-show-text">{evento.descripcion}</p>
        <p className="evento-show-text"><span className="evento-show-label">Inicio:</span> {evento.fecha_inicio}</p>
        <p className="evento-show-text"><span className="evento-show-label">Fin:</span> {evento.fecha_final}</p>
        <p className="evento-show-text"><span className="evento-show-label">Lugar:</span> {evento.lugar}</p>

    </div>
</div>
    );
}