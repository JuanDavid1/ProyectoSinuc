-- Inserción en la tabla empresas
INSERT INTO `empresas` 
(`tipo_entidad`, `nit`, `verificacion`, `razonsocial`, `correo`, `telefono`, `direccion`, `estado`) 
VALUES
(4, '844001355', '123', 'HOSPITAL JUAN HERNANDO URREGO', 'esejhu@hospitaldeaguazul.gov.co', '3160257983', 'Calle 11 No. 15 - 40', 1);

-- Inserción en la tabla usuarios
INSERT INTO `usuarios` 
(`usuario`, `contrasena`, `documento`, `tipdocumento`, `nombre1`, `nombre2`, `apellido1`, `apellido2`, `rol`, `idempresa`, `estado`, `fecharec`) 
VALUES
('HOSPITALHEU', '101010', '844001355', 'CC', 'HOSPITAL', 'JUAN', 'HERNANDO', 'URREGO', 4, 
  (SELECT idempresa FROM empresas WHERE nit = '844001355'), 1, '2024-10-18 10:00:00');

-- Inserción en la tabla permisos_opciones
INSERT INTO `permisos_opciones` 
(`id_usuaio`, `id_opcion`, `p_listar`, `p_registrar`, `p_modificar`, `p_eliminiar`, `p_anular`, `p_imprimir`) 
VALUES
(
  (SELECT idusuario FROM usuarios WHERE usuario = 'HOSPITALHEU'), 
  10, 1, 1, 1, 1, 1, 1
);

-- Inserción en la tabla permisos_modulos
INSERT INTO `permisos_modulos` 
(`id_usuario`, `id_modulo`) 
VALUES
(
  (SELECT idusuario FROM usuarios WHERE usuario = 'HOSPITALHEU'), 
  1
);
