import { Link, Outlet } from "react-router-dom";
import React from "react";
import "./ComunidadLayout.css";

export default function ComunidadLayout() {
    return (
        <div className="comunidad-layout">

            <nav className="comunidad-nav">

                <Link className="comunidad-link" to="">
                    Inicio
                </Link>

                <Link className="comunidad-link" to="usuarios">
                    Usuarios
                </Link>

                <Link className="comunidad-link" to="solicitudes">
                    Solicitudes
                </Link>

                <Link className="comunidad-link" to="amigos">
                    Amigos
                </Link>

            </nav>

            <hr className="comunidad-separator" />

            <main className="comunidad-content">
                <Outlet />
            </main>

        </div>
    );
}