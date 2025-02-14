CREATE DATABASE pos;

USE pos;

CREATE TABLE `usuarios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `usuario` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `perfil` VARCHAR(255) NOT NULL,
  `foto` VARCHAR(255) DEFAULT NULL,
  `estado`INT NOT NULL DEFAULT 1,
  `ultimo_login` DATETIME DEFAULT NULL,
  `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `perfil`, `foto`, `estado`, `ultimo_login`, `fecha`) VALUES
(3, 'usuario Administrador', 'admin', 'admin123', 'Administrador', '', 1, '0000-00-00 00:00:00', '2025-02-13 16:35:27');



SELECT * FROM usuarios;


drop database pos;
