import { useState } from "react";
import api from "../../api";
import { Link, useNavigate } from "react-router-dom";
import "./Register.css";

export default function Register() {
    const navigate = useNavigate();

    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);

    const register = async (e) => {
        e.preventDefault();
        setError("");
    if (!name.trim() || !email.trim() || !password || !passwordConfirmation) {
        setError("Todos los campos son obligatorios");
        return;
    }
    try {
        setLoading(true);
        const response = await api.post("/register", { name, email, password, password_confirmation: passwordConfirmation });
        localStorage.setItem("token", response.data.token);
        localStorage.setItem("user", JSON.stringify(response.data.user));
        navigate("/comunidad");
    } catch (error) {
        setError(error.response?.data?.message || "Error al registrar usuario");
    } finally {
        setLoading(false);
    }
    };

    return(
            <div className="register-container">

                <div className="register-card">

                    <h2 className="register-title">
                        Crear Cuenta
                    </h2>

                    {error && (
                        <div className="auth-error">
                            {error}
                        </div>
                    )}

                    <form onSubmit={register} className="register-form">

                        <input
                            type="text"
                            placeholder="Nombre"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                        />

                        <input
                            type="email"
                            placeholder="Email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                        />

                        <input
                            type="password"
                            placeholder="Contraseña"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                        />

                        <input
                            type="password"
                            placeholder="Repite contraseña"
                            value={passwordConfirmation}
                            onChange={(e) => setPasswordConfirmation(e.target.value)}
                        />

                        <button type="submit" disabled={loading}>
                            {loading ? "Cargando..." : "Registrarse"}
                        </button>

                    </form>

                    <div className="register-links">
                        <p>
                            ¿Ya tienes cuenta? <Link to="/login">Inicia sesión</Link>
                        </p>
                    </div>

                </div>

            </div>
        );
}