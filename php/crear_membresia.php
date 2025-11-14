<?php
include 'conexion.php';

$db->exec("CREATE TABLE IF NOT EXISTS membresias (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  usuario_id INTEGER,
  estado TEXT,
  fecha_pago TEXT,
  fecha_vencimiento TEXT
)");

echo "Tabla 'membresias' creada correctamente.";
?>