import { useEffect, useState } from "react";
import api from "../../api";
import "./Configuracion.css";

export default function Configuracion() {

    const [user, setUser] = useState(null);

    const [name, setName] = useState("");
    const [email, setEmail] = useState("");

    const [password, setPassword] = useState("");
    const [passwordConfirmar, setPasswordConfirmar] = useState("");

    const [loading, setLoading] = useState(true);
    const [guardando, setGuardando] = useState(false);

    useEffect(() => {
        cargarUsuario();
    }, []);

    const cargarUsuario = async () => {
        try {
            const response = await api.get("/perfil");

            setUser(response.data.user);
            setName(response.data.user.name);
            setEmail(response.data.user.email);

        } catch (error) {
            console.log(error);
        } finally {
            setLoading(false);
        }
    };

    const guardarCambios = async (e) => {
        if (e) e.preventDefault();

        if (!name.trim() || !email.trim()) {
            alert("Nombre y email son obligatorios");
            return;
        }

        if (password && password !== passwordConfirmar) {
            alert("Las contraseñas no coinciden");
            return;
        }

        try {
            setGuardando(true);

            const payload = {
                name,
                email,
            };

            
            if (password.trim() !== "") {
                payload.password = password;
                payload.password_confirmation = passwordConfirmar;
            }

            await api.put("/perfil", payload);

            alert("Perfil actualizado correctamente");

            setPassword("");
            setPasswordConfirmar("");

            cargarUsuario();

        } catch (error) {
            console.log(error);

            alert(
                error.response?.data?.message ||
                "Error al actualizar perfil"
            );

        } finally {
            setGuardando(false);
        }
    };

    if (loading) {
        return <div>Cargando configuración...</div>;
    }

    if (!user) {
        return <div>No hay usuario</div>;
    }

    return (
        <div className="config-container">

            <h2>Configuración de cuenta</h2>

            <form onSubmit={guardarCambios} className="config-form">

                <label>Nombre</label>
                <input
                    type="text"
                    value={name}
                    onChange={(e) => setName(e.target.value)}
                />

                <label>Email</label>
                <input
                    type="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                />

                <label>Nueva contraseña</label>
                <input
                    type="password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                />

                <label>Confirmar contraseña</label>
                <input
                    type="password"
                    value={passwordConfirmar}
                    onChange={(e) => setPasswordConfirmar(e.target.value)}
                />

                <button
                    type="submit"
                    disabled={guardando}
                    className="btn-guardar"
                >
                    {guardando ? "Guardando..." : "Guardar cambios"}
                </button>

            </form>

        </div>
    );
}