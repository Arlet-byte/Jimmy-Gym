<?php
include 'conexion.php';

$db->exec("CREATE TABLE IF NOT EXISTS clases (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  nombre TEXT,
  cupo INTEGER,
  fecha TEXT,
  hora TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS reservas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  usuario_id INTEGER,
  clase_id INTEGER,
  confirmada INTEGER
)");

echo "Tablas 'clases' y 'reservas' creadas correctamente.";
?>