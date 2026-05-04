-- =========================================================
-- SCRIPT DE TABLAS INICIALES PARA SISTEMA "CLIENTE FELIZ"
-- AUTOR: CHAROL CARRASCO
-- =========================================================

-- 1. Tabla usuario
CREATE TABLE usuario (
    rut_usuario VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    rol VARCHAR(20) -- 'reclutador' o 'candidato'
);

-- 2. Tabla candidato
-- (redundante con usuario, usar si quieres datos extra en candidatos)
CREATE TABLE candidato (
    rut_cantidado VARCHAR(20) PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    email VARCHAR(100),
    profesion VARCHAR(50)
);

-- 3. Tabla ofertas_laborales
CREATE TABLE ofertas_laborales (
    id_oferta INT IDENTITY(1,1) PRIMARY KEY,
    titulo VARCHAR(100),
    descripcion TEXT,
    fecha_publicacion DATE,
    estado VARCHAR(20), -- 'activa', 'inactiva'
    rut_usuario VARCHAR(20),
    FOREIGN KEY(rut_usuario) REFERENCES usuario(rut_usuario)
);

-- 4. Tabla postulaciones
CREATE TABLE postulaciones (
    id_postulacion INT IDENTITY(1,1) PRIMARY KEY,
    id_oferta INT,
    rut_candidato VARCHAR(20),
    fecha_postulacion DATE,
    estado VARCHAR(30),
    comentario TEXT,
    ultima_actualizacion DATE,
    FOREIGN KEY(id_oferta) REFERENCES ofertas_laborales(id_oferta),
    FOREIGN KEY(rut_candidato) REFERENCES usuario(rut_usuario)
);

-- 5. Carga de datos ficticios

-- Usuarios (reclutador y candidatos)
INSERT INTO usuario VALUES
('12345678-9', 'Charol', 'Carrasco', 'reclutador@clientefeliz.cl', '1234seguro', 'reclutador'),
('22345678-9', 'Ana', 'Pérez', 'ana@correo.com', '5678seguro', 'candidato'),
('32345678-9', 'Luis', 'López', 'luis@correo.com', '9101seguro', 'candidato');

-- Candidatos
INSERT INTO candidato VALUES
('22345678-9', 'Ana', 'Pérez', 'ana@correo.com', 'Químico'),
('32345678-9', 'Luis', 'López', 'luis@correo.com', 'Ingeniero');

-- Ofertas laborales
INSERT INTO ofertas_laborales(titulo, descripcion, fecha_publicacion, estado, rut_usuario) VALUES
('Ejecutivo de Ventas', 'Responsable de ventas telefónicas a clientes nuevos y existentes.', '2024-06-05', 'activa', '12345678-9'),
('Supervisor', 'Encargado de supervisar equipos de ventas.', '2024-06-07', 'activa', '12345678-9');

-- Postulaciones
INSERT INTO postulaciones(id_oferta, rut_candidato, fecha_postulacion, estado, comentario, ultima_actualizacion) VALUES
(1, '22345678-9', '2024-06-08', 'Revisando', '', '2024-06-09'),
(1, '32345678-9', '2024-06-08', 'Postulando', '', '2024-06-09'),
(2, '22345678-9', '2024-06-10', 'Entrevista Psicológica', 'Listo para entrevista psicológica', '2024-06-12');