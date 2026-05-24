import { Link, Outlet, useNavigate } from "react-router-dom";
import "./MainLayout.css";
import api from "../api";

export default function MainLayout() {
    const user = JSON.parse(localStorage.getItem("user"));
    const navigate = useNavigate();

    const logout = async () => {
        try {
            await api.post("/logout");
            localStorage.removeItem("user");
            localStorage.removeItem("token");
            navigate("/");
        } catch (error) {
            console.log(error);
        }
    };

    return (
        <div className="layout-container">

            
            <nav className="sidebar">

                <h2 className="logo">Zona Gamer</h2>

                <Link to="/comunidad">Comunidad</Link>
                <Link to="/eventos">Eventos</Link>
                <Link to="/noticias">Noticias</Link>

                <Link to={`/comunidad/perfil/${user?.id}`}>
                    Perfil
                </Link>

                <button className="logout-btn" onClick={logout}>
                    Cerrar Sesión
                </button>

            </nav>


            <main className="main-content">
                <Outlet />
            </main>

        </div>
    );
}