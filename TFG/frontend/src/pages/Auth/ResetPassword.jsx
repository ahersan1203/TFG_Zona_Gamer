import { useState } from "react";
import api from "../../api";
import { Link, useNavigate, useSearchParams } from "react-router-dom";

export default function ResetPassword() {
    
    const navigate = useNavigate();
    const [searchParams] = useSearchParams();
    const email = searchParams.get("email");
    const token = searchParams.get("token");

    const [password, setPassword] = useState("");
    const [passwordConfirmation, setPasswordConfirmation] = useState("");
    const [error, setError] = useState("");
    const [loading, setLoading] = useState(false);

    const resetPassword = async (e) => {
        e.preventDefault();
        setError("");
        if (!password || !passwordConfirmation) {
            setError("Todos los campos son obligatorios");
            return;
        }
        if (password !== passwordConfirmation) {
            setError("Las contraseñas no coinciden");
            return;
        }
        try {
            setLoading(true);
            await api.post("/reset-password", { password, password_confirmation: passwordConfirmation, token, email });
            navigate("/comunidad");
        } catch (error) {
            setError(error.response?.data?.message || "Error al restablecer la contraseña");
        } finally {
            setLoading(false);
        }

        return(
            <div>
                <h2>Restablecer Contraseña</h2>
                {error && <p>{error}</p>}
                <form onSubmit={resetPassword}>
                    <input
                        type="password"
                        placeholder="Nueva Contraseña"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                    <input
                        type="password"
                        placeholder="Confirmar Contraseña"
                        value={passwordConfirmation}
                        onChange={(e) => setPasswordConfirmation(e.target.value)}
                    />
                    <button type="submit">Restablecer Contraseña</button>
                    <Link to="/login">Iniciar Sesión</Link>
                </form>
            </div>
        )
    };
}