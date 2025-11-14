<?php
include 'conexion.php';

$db->exec("CREATE TABLE IF NOT EXISTS rutinas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  usuario_id INTEGER,
  descripcion TEXT
)");

echo "Tabla 'rutinas' creada correctamente.";
?>