import { useEffect, useState } from "react";
import api from "../../api";
import { useNavigate, useParams } from "react-router-dom";
import "./NoticiaEdit.css";

export default function NoticiaEdit() {
    const { id } = useParams();
    const navigate = useNavigate();

    const [formData, setFormData] = useState({
        titulo: "",
        contenido: "",
        categoria_id: "",
    });

    const [categorias, setCategorias] = useState([]);
    const [loading, setLoading] = useState(false);
    const [loadingData, setLoadingData] = useState(true);
    const [error, setError] = useState("");

    useEffect(() => {
        cargarDatos();
    }, [id]);

    const cargarDatos = async () => {
        try {
            const [noticiaRes, categoriasRes] = await Promise.all([
                api.get(`/noticias/${id}`),
                api.get("/categorias")
            ]);

            const noticia = noticiaRes.data.data;

            setFormData({
                titulo: noticia.titulo || "",
                contenido: noticia.contenido || "",
                categoria_id: noticia.categoria_id || "",
            });

            setCategorias(categoriasRes.data || []);

        } catch (error) {
            setError("Error al cargar la noticia");
        } finally {
            setLoadingData(false);
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
            setError("Título, contenido y categoría son obligatorios");
            return;
        }

        try {
            setLoading(true);

            await api.put(`/noticias/${id}`, {
                titulo: formData.titulo,
                contenido: formData.contenido,
                categoria_id: formData.categoria_id
            });

            navigate("/noticias");

        } catch (error) {
            setError(error.response?.data?.message || "Error al actualizar la noticia");
        } finally {
            setLoading(false);
        }
    };

    if (loadingData) {
        return <p className="noticia-edit-loading">Cargando...</p>;
    }

    return (
        <div className="noticia-edit-container">

            <div className="noticia-edit-card">

                <h1>Editar noticia</h1>

                {error && (
                    <p className="noticia-edit-error">{error}</p>
                )}

                <form onSubmit={handleSubmit} className="noticia-edit-form">

                    <div>
                        <label>Título</label>
                        <input
                            type="text"
                            name="titulo"
                            value={formData.titulo}
                            onChange={handleChange}
                        />
                    </div>

                    <div>
                        <label>Contenido</label>
                        <textarea
                            name="contenido"
                            value={formData.contenido}
                            onChange={handleChange}
                        />
                    </div>

                    <div>
                        <label>Categoría</label>
                        <select
                            name="categoria_id"
                            value={formData.categoria_id}
                            onChange={handleChange}
                        >
                            <option value="">Seleccione una categoría</option>

                            {categorias.map((categoria) => (
                                <option key={categoria.id} value={categoria.id}>
                                    {categoria.nombre}
                                </option>
                            ))}
                        </select>
                    </div>

                    <button type="submit" disabled={loading}>
                        {loading ? "Guardando..." : "Guardar cambios"}
                    </button>

                </form>

            </div>

        </div>
    );
}