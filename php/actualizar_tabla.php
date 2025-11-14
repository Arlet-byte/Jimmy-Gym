<?php
include 'conexion.php';

// Agregar columnas si no existen
$db->exec("ALTER TABLE usuarios ADD COLUMN peso REAL");
$db->exec("ALTER TABLE usuarios ADD COLUMN altura REAL");
$db->exec("ALTER TABLE usuarios ADD COLUMN objetivo TEXT");

echo "Columnas agregadas correctamente.";
?>