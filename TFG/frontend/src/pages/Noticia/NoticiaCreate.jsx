import { useEffect, useState } from "react";
import api from "../../api";
import { useNavigate } from "react-router-dom";
import "./NoticiaCreate.css";

export default function NoticiaCreate() {
    const navigate = useNavigate();

    const [formData, setFormData] = useState({
        titulo: "",
        contenido: "",
        categoria_id: "",
    });

    const [categorias, setCategorias] = useState([]);
    const [loading, setLoading] = useState(false);
    const [loadingCategorias, setLoadingCategorias] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        cargarCategorias();
    }, []);

    const cargarCategorias = async () => {
        try {
            const response = await api.get("/categorias");
            setCategorias(response.data || []);
        } catch (error) {
            setError("No se pudieron cargar las categorías");
        } finally {
            setLoadingCategorias(false);
        }
    };

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setError("");

        if (!formData.titulo || !formData.contenido || !formData.categoria_id) {
            setError("Todos los campos son obligatorios");
            return;
        }

        try {
            setLoading(true);

            await api.post("/noticias", {
                titulo: formData.titulo,
                contenido: formData.contenido,
                categoria_id: formData.categoria_id
            });

            navigate("/noticias");

        } catch (error) {
            setError(error.response?.data?.message || "Error al crear la noticia");
        } finally {
            setLoading(false);
        }
    };

    if (loadingCategorias) {
        return <p className="noticia-create-loading">Cargando categorías...</p>;
    }

    return (
        <div className="noticia-create-container">

            <div className="noticia-create-card">

                <h1>Crear Noticia</h1>

                {error && <div className="noticia-error">{error}</div>}

                <form onSubmit={handleSubmit} className="noticia-create-form">

                    <input
                        type="text"
                        name="titulo"
                        placeholder="Título"
                        value={formData.titulo}
                        onChange={handleChange}
                    />

                    <textarea
                        name="contenido"
                        placeholder="Contenido"
                        value={formData.contenido}
                        onChange={handleChange}
                    />

                    <select
                        name="categoria_id"
                        value={formData.categoria_id}
                        onChange={handleChange}
                    >
                        <option value="">Selecciona categoría</option>

                        {categorias.map((categoria) => (
                            <option key={categoria.id} value={categoria.id}>
                                {categoria.nombre}
                            </option>
                        ))}
                    </select>

                    <button type="submit" disabled={loading}>
                        {loading ? "Creando..." : "Crear Noticia"}
                    </button>

                </form>

            </div>

        </div>
    );
}