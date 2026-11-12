CREATE DATABASE IF NOT EXISTS `parcial_web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `parcial_web`;

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Registros de prueba (Las contraseñas de prueba corresponden a: "123456")
INSERT INTO `usuarios` (`nombre`, `email`, `password`) VALUES
('Luz Ludueña', 'luz@example.com', '$2y$10$e84W/32lE..5kP/wGg8eEe4uXzK/0y4G7/Q0J.15.qjH2x3L7H.4W'),
('Juan Perez', 'juan@example.com', '$2y$10$e84W/32lE..5kP/wGg8eEe4uXzK/0y4G7/Q0J.15.qjH2x3L7H.4W'),
('Maria Gomez', 'maria@example.com', '$2y$10$e84W/32lE..5kP/wGg8eEe4uXzK/0y4G7/Q0J.15.qjH2x3L7H.4W'),
('Carlos Rodriguez', 'carlos@example.com', '$2y$10$e84W/32lE..5kP/wGg8eEe4uXzK/0y4G7/Q0J.15.qjH2x3L7H.4W'),
('Ana Fernandez', 'ana@example.com', '$2y$10$e84W/32lE..5kP/wGg8eEe4uXzK/0y4G7/Q0J.15.qjH2x3L7H.4W'),
('Lucas Lopez', 'lucas@example.com', '$2y$10$e84W/32lE..5kP/wGg8eEe4uXzK/0y4G7/Q0J.15.qjH2x3L7H.4W'),
('Sofia Martinez', 'sofia@example.com', '$2y$10$e84W/32lE..5kP/wGg8eEe4uXzK/0y4G7/Q0J.15.qjH2x3L7H.4W'),
('Diego Sanchez', 'diego@example.com', '$2y$10$e84W/32lE..5kP/wGg8eEe4uXzK/0y4G7/Q0J.15.qjH2x3L7H.4W');