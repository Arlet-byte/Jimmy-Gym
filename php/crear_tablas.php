<?php
include 'conexion.php';

$db->exec("CREATE TABLE IF NOT EXISTS usuarios (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre TEXT,
  correo TEXT UNIQUE,
  contraseña TEXT
)");
echo "Tablas creadas correctamente.";
?>