<?php
include 'conexion.php';

$db->exec("CREATE TABLE IF NOT EXISTS progreso (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  usuario_id INTEGER,
  fecha TEXT,
  peso REAL,
  cintura REAL,
  pecho REAL
)");

echo "Tabla 'progreso' creada correctamente.";
?>