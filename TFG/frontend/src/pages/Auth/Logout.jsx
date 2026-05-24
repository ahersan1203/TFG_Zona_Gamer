import {useNavigate} from "react-router-dom";
import api from "../../api";

export default function Logout() {
    const navigate = useNavigate();

    const logout = async () => {
        try {
            await api.post("/logout");
            navigate("/");
        } catch (error) {
            console.log(error);
        }
    };

    return (
        <button className="logout-btn" onClick={logout}>
            Cerrar sesión
        </button>
    );
}