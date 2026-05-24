import { BrowserRouter, Route, Routes } from "react-router-dom";

import MainLayout from "./layouts/MainLayout";
import ComunidadLayout from "./layouts/ComunidadLayout";

import Comunidad from "./pages/Comunidad/Comunidad";
import UsuariosLista from "./pages/Comunidad/UsuariosLista";
import Solicitudes from "./pages/Comunidad/Solicitudes";
import CrearPublicacion from "./pages/Comunidad/CrearPublicacion";
import CrearComentario from "./pages/Comunidad/CrearComentario";
import PerfilUsuarios from "./pages/Comunidad/PerfilUsuario";
import Chat from "./pages/Comunidad/Chat";
import Amigos from "./pages/Comunidad/Amigos";

import Perfil from "./pages/Perfil/Perfil";
import EditarComentario from "./pages/Perfil/EditarComentario";
import EditarPublicacion from "./pages/Perfil/EditarPublicacion";
import Configuracion from "./pages/Perfil/Configuracion";

import Login from "./pages/Auth/Login";
import Register from "./pages/Auth/Register";
import ForgotPassword from "./pages/Auth/ForgotPassword";
import ResetPassword from "./pages/Auth/ResetPassword";

import AdminPanel from "./pages/Admin/AdminPanel";
import EventoAdmin from "./pages/Admin/Eventos";
import NoticiaAdmin from "./pages/Admin/Noticias";
import ComunidadAdmin from "./pages/Admin/Comunidad";

import Eventos from "./pages/Evento/Eventos";
import EventoCreate from "./pages/Evento/EventoCreate";
import EventoEdit from "./pages/Evento/EventoEdit";
import EventoShow from "./pages/Evento/EventoShow";

import Noticias from "./pages/Noticia/Noticia";
import NoticiaCreate from "./pages/Noticia/NoticiaCreate";
import NoticiaEdit from "./pages/Noticia/NoticiaEdit";
import NoticiaShow from "./pages/Noticia/NoticiaShow";
import EditarUsuario from "./pages/Admin/EditarUsuario";

function App() {
  return (
    <BrowserRouter>
      <Routes>

        {/* AUTH */}
        <Route path="/" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/forgot-password" element={<ForgotPassword />} />
        <Route path="/reset-password/:token" element={<ResetPassword />} />

        {/* APP CON LAYOUT */}
        <Route element={<MainLayout />}>
          
          {/* COMUNIDAD */}
          <Route path="/comunidad" element={<ComunidadLayout />}>
            <Route index element={<Comunidad />} />
            <Route path="usuarios" element={<UsuariosLista />} />
            <Route path="solicitudes" element={<Solicitudes />} />
            <Route path="crear" element={<CrearPublicacion />} />
            <Route path="publicacion/:id/comentario" element={<CrearComentario />} />
            <Route path="perfil/:id" element={<PerfilUsuarios />} />
            <Route path="chat/:id" element={<Chat />} />
            <Route path="amigos" element={<Amigos />} />
            <Route path="publicacion/editar/:id" element={<EditarPublicacion />} />
            <Route path="comentario/editar/:id" element={<EditarComentario />} />
          </Route>

          {/* PERFIL */}
          <Route path="/perfil" element={<Perfil />} />
          <Route path="/perfil/editarComentario/:id" element={<EditarComentario />} />
          <Route path="/perfil/editarPublicacion/:id" element={<EditarPublicacion />} />
          <Route path="/perfil/configuracion" element={<Configuracion />} />

          {/* ADMIN */}
          <Route path="/admin" element={<AdminPanel />} />
          <Route path="/admin/eventos" element={<EventoAdmin />} />
          <Route path="/admin/noticias" element={<NoticiaAdmin />} />
          <Route path="/admin/comunidad" element={<ComunidadAdmin />} />
          <Route path="/admin/usuarios/:id/editar" element={<EditarUsuario />} />

          {/* EVENTOS */}
          <Route path="/eventos" element={<Eventos />} />
          <Route path="/eventos/crear" element={<EventoCreate />} />
          <Route path="/eventos/:id/editar" element={<EventoEdit />} />
          <Route path="/eventos/:id" element={<EventoShow />} />

          {/* NOTICIAS */}
          <Route path="/noticias" element={<Noticias />} />
          <Route path="/noticias/crear" element={<NoticiaCreate />} />
          <Route path="/noticias/:id/edit" element={<NoticiaEdit />} />
          <Route path="/noticias/:id" element={<NoticiaShow />} />

        </Route>

      </Routes>
    </BrowserRouter>
  );
}

export default App;