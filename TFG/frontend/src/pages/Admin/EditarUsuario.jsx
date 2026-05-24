import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import api from "../../api";
import "./EditarUsuario.css";   

export default function EditarUsuario() {

    const { id } = useParams();
    const navigate = useNavigate();

    const [loading, setLoading] = useState(true);

    const [form, setForm] = useState({
        nombre: "",
        email: "",
        rol_id: ""
    });

    useEffect(() => {
        cargarUsuario();
    }, [id]);

    const cargarUsuario = async () => {
        try {
            const response = await api.get(`/admin/usuario/${id}`);

            const usuario = response.data.usuario;

            if (!usuario) {
                alert("Usuario no encontrado");
                return;
            }

            setForm({
                nombre: usuario.nombre || usuario.name || "",
                email: usuario.email || "",
                rol_id: usuario.rol_id || ""
            });

        } catch (error) {
            console.error("Error al cargar usuario:", error);
            alert("No se pudo cargar el usuario");
        } finally {
            setLoading(false);
        }
    };

    const submit = async (e) => {
        e.preventDefault();

        try {
            await api.put(`/usuarios/${id}`, {
                nombre: form.nombre,
                email: form.email,
                rol_id: form.rol_id
            });

            alert("Usuario actualizado correctamente");
            navigate("/admin");

        } catch (error) {
            console.error("Error al actualizar:", error);

            if (error.response?.data) {
                console.log("ERROR BACKEND:", error.response.data);
            }

            alert("Error al actualizar usuario");
        }
    };

    if (loading) {
        return <h2>Cargando usuario...</h2>;
    }

    return (
        <div className="edit-user-container">

            <h2>Editar Usuario</h2>

            <form onSubmit={submit}>

                <div>
                    <label>Nombre</label>
                    <input
                        type="text"
                        value={form.nombre}
                        onChange={(e) =>
                            setForm({ ...form, nombre: e.target.value })
                        }
                        required
                    />
                </div>

                <div>
                    <label>Email</label>
                    <input
                        type="email"
                        value={form.email}
                        onChange={(e) =>
                            setForm({ ...form, email: e.target.value })
                        }
                        required
                    />
                </div>

                <div>
                    <label>Rol</label>
                    <select
                        value={form.rol_id}
                        onChange={(e) =>
                            setForm({ ...form, rol_id: e.target.value })
                        }
                    >
                        <option value="">Selecciona un rol</option>
                        <option value="1">Administrador</option>
                        <option value="2">Usuario</option>
                    </select>
                </div>

                <button type="submit">
                    Guardar cambios
                </button>

            </form>

        </div>
    );
}