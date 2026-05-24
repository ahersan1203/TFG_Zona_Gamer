import { useState } from "react";
import api from "../../api";
import { useNavigate, Link } from "react-router-dom";
import "./Login.css";

export default function Login() {
    const navigate = useNavigate();

    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);


    const login = async (e) => {
        e.preventDefault();
        setError("");

        if (!email.trim() || !password) {
            setError("Todos los campos son obligatorios");
            return;
        }

        try {
            setLoading(true);
            const response = await api.post("/login", { email, password });
            localStorage.setItem("token", response.data.token);
            localStorage.setItem("user", JSON.stringify(response.data.user));
            navigate("/comunidad");
        }
        catch (error) {
            setError(error.response?.data?.message || "Error al iniciar sesión");
        }
        finally {
            setLoading(false);
        }
    };

    return (
            <div className="auth-container">
                <div className="auth-card">

                    <h1>Iniciar sesión</h1>

                    {error && <div className="auth-error">{error}</div>}

                    <form onSubmit={login}>
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

                        <button type="submit" disabled={loading}>
                            {loading ? "Cargando..." : "Iniciar sesión"}
                        </button>
                    </form>

                    <div className="auth-links">
                        <p><Link to="/register">Registrarse</Link></p>
                    </div>

                </div>
            </div>
        );
}