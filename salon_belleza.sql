--Crear la base de datos
CREATE DATABASE IF NOT EXISTS salon_belleza;
USE salon_belleza;

-- Tabla usuarios
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla servicios
CREATE TABLE servicios (
    id_servicio INT PRIMARY KEY AUTO_INCREMENT,
    nombre_servicio VARCHAR(100) NOT NULL,
    descripcion TEXT,
    duracion INT NOT NULL, -- duración en minutos
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    activo BOOLEAN DEFAULT TRUE
);

-- Tabla estilistas
CREATE TABLE estilistas (
    id_estilista INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    especialidad VARCHAR(100),
    activo BOOLEAN DEFAULT TRUE
);

-- Tabla horarios_disponibles
CREATE TABLE horarios_disponibles (
    id_horario INT PRIMARY KEY AUTO_INCREMENT,
    id_estilista INT,
    dia_semana INT NOT NULL, -- 1=Lunes, 7=Domingo
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    FOREIGN KEY (id_estilista) REFERENCES estilistas(id_estilista)
);

-- Tabla citas
CREATE TABLE citas (
    id_cita INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT,
    id_servicio INT,
    id_estilista INT,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'completada') DEFAULT 'pendiente',
    comentarios TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio),
    FOREIGN KEY (id_estilista) REFERENCES estilistas(id_estilista)
);

-- Tabla historial_cambios
CREATE TABLE historial_cambios (
    id_historial INT PRIMARY KEY AUTO_INCREMENT,
    id_cita INT,
    estado_anterior ENUM('pendiente', 'confirmada', 'cancelada', 'completada'),
    estado_nuevo ENUM('pendiente', 'confirmada', 'cancelada', 'completada'),
    fecha_cambio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_admin VARCHAR(50),
    comentario TEXT,
    FOREIGN KEY (id_cita) REFERENCES citas(id_cita)
);

-- Insertar algunos servicios de ejemplo
INSERT INTO servicios (nombre_servicio, descripcion, duracion, precio) VALUES
('Corte de Cabello', 'Corte y estilo personalizado', 30, 15.00),
('Manicure', 'Limpieza y pintado de uñas', 45, 20.00),
('Pedicure', 'Tratamiento completo para pies', 60, 25.00),
('Tinte de Cabello', 'Coloración profesional', 120, 50.00),
('Alisado', 'Alisado permanente', 180, 80.00),
('Peinado', 'Peinado para ocasiones especiales', 60, 30.00);

-- Insertar algunos estilistas de ejemplo
INSERT INTO estilistas (nombre, apellido, especialidad) VALUES
('Alex', 'González', 'Coloración'),
('Juan', 'Pérez', 'Corte de Cabello'),
('Carlos', 'Martínez', 'semiondulado');
