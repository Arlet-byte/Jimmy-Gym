<?php
include 'conexion.php';

$db->exec("CREATE TABLE IF NOT EXISTS asistencia (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  usuario_id INTEGER,
  fecha TEXT,
  hora TEXT
)");

echo "Tabla 'asistencia' creada correctamente.";
?>