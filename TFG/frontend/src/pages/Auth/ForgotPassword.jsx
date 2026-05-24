import { useState } from "react";
import api from "../../api";
import { Link , useNavigate} from "react-router-dom";

export default function ForgotPassword() {
    const navigate = useNavigate();
    const [email, setEmail] = useState("");
    const [error, setError] = useState("");
    const [success, setSuccess] = useState("");
    const [loading, setLoading] = useState(false);

    const enviarCorreo = async (e) => {
        e.preventDefault();
        setError("");
        setSuccess("");

        if (!email.trim()) {
            setError("Todos los campos son obligatorios");
            return;
        }

        try {
            setLoading(true);
            const response = await api.post("/forgot-password", { email });
            setSuccess(response.data.message);
            navigate("/");
        }
        catch (error) {
            setError(error.response?.data?.message || "Error al enviar el correo");
        }
        finally {
            setLoading(false);
        }
    };
    return (
        <div>
            <h1>Recuperar contraseña</h1>
            <form onSubmit={enviarCorreo}>
                <input
                    type="email"
                    placeholder="Correo"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                />
                <button type="submit">Enviar correo</button>
            </form>
            {error && <p>{error}</p>}
            {success && <p>{success}</p>}
            <Link to="/login"></Link>
        </div>
    );
}