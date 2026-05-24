import { useEffect, useState } from "react";
import api from "../../api";
import { useNavigate, useParams } from "react-router-dom";
import "./EventoEdit.css";

export default function EventoEdit() {
    const navigate = useNavigate();
    const { id } = useParams();

    const [form, setForm] = useState({
        nombre: "",
        fecha_inicio: "",
        fecha_final: "",
        lugar: "",
        descripcion: ""
    });

    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");
    const [cargardatos, setCargardatos] = useState(false);

    useEffect(() => {
        cargarEvento();
    }, [id]);

    const cargarEvento = async () => {
        try {
            const response = await api.get(`/eventos/${id}`);

            const evento = response.data;

            setForm({
                nombre: evento.nombre || "",
                fecha_inicio: evento.fecha_inicio || "",
                fecha_final: evento.fecha_final || "",
                lugar: evento.lugar || "",
                descripcion: evento.descripcion || ""
            });
        } catch (error) {
            console.log("ERROR CARGANDO EVENTO:", error.response?.data || error);
            setError("No se pudo cargar el evento");
        } finally {
            setCargardatos(true);
        }
    };

    const handleChange = (e) => {
        setForm({
            ...form,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError("");

        if (
            !form.nombre ||
            !form.fecha_inicio ||
            !form.fecha_final ||
            !form.lugar ||
            !form.descripcion
        ) {
            setError("Todos los campos son obligatorios");
            return;
        }

        try {
            setLoading(true);

            await api.put(`/eventos/${id}`, form);

            navigate("/admin");

        } catch (error) {
            console.log("ERROR ACTUALIZANDO:", error.response?.data || error);

            setError(
                error.response?.data?.message ||
                "Error al actualizar el evento"
            );
        } finally {
            setLoading(false);
        }
    };

    if (!cargardatos) {
        return <div>Cargando...</div>;
    }

    return (
        <div className="evento-edit-container">

            <h1>Editar evento</h1>

            {error && (
                <p className="evento-error">
                    {error}
                </p>
            )}

            <form onSubmit={handleSubmit} className="evento-edit-form">

                <div>
                    <label>Nombre</label>
                    <input
                        type="text"
                        name="nombre"
                        value={form.nombre}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Descripción</label>
                    <textarea
                        name="descripcion"
                        value={form.descripcion}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Fecha inicio</label>
                    <input
                        type="date"
                        name="fecha_inicio"
                        value={form.fecha_inicio}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Fecha final</label>
                    <input
                        type="date"
                        name="fecha_final"
                        value={form.fecha_final}
                        onChange={handleChange}
                    />
                </div>

                <div>
                    <label>Lugar</label>
                    <input
                        type="text"
                        name="lugar"
                        value={form.lugar}
                        onChange={handleChange}
                    />
                </div>

                <button type="submit" disabled={loading}>
                    {loading ? "Guardando..." : "Guardar cambios"}
                </button>

            </form>

        </div>
    );
}