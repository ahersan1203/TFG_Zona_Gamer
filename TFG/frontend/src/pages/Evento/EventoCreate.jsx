import {useState} from "react";
import api from "../../api";
import {useNavigate} from "react-router-dom";
import "./EventoCreate.css";

export default function EventoCreate() {
    const navigate = useNavigate();
    const [form, setForm] = useState({
        nombre: "",
        fecha_inicio: "",
        fecha_final: "",
        lugar: "",
        descripcion: ""
    });

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

    const handleChange = (e) => {
        setForm({...form, [e.target.name]: e.target.value});
    };
    const handleSubmit = async (e) => {
        e.preventDefault();
        if(!form.descripcion || !form.fecha_final || !form.fecha_inicio || !form.lugar || !form.nombre) {
            setError("Todos los campos son obligatorios");
            return;
        }
        try{
            setLoading(true);
            await api.post("/eventos", form);
            navigate("/eventos");
        }
        catch (error) {
            setError(error.response?.data?.message || "Error al crear el evento");
        }
        finally {
            setLoading(false);
        }
        
    };

    return (
    <div className="evento-create-container">

        <h1>Crear evento</h1>

        {error && <p className="evento-error">{error}</p>}

        <form onSubmit={handleSubmit} className="evento-form">

            <input name="nombre" placeholder="Nombre" onChange={handleChange} value={form.nombre} />

            <input name="fecha_inicio" type="date" onChange={handleChange} value={form.fecha_inicio} />

            <input name="fecha_final" type="date" onChange={handleChange} value={form.fecha_final} />

            <input name="lugar" placeholder="Lugar" onChange={handleChange} value={form.lugar} />

            <textarea name="descripcion" placeholder="Descripción" onChange={handleChange} value={form.descripcion} />

            <button type="submit" disabled={loading}>
                {loading ? "Creando..." : "Crear evento"}
            </button>

        </form>

    </div>
);
}