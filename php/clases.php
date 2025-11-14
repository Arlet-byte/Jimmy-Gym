<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$result = $db->query("SELECT * FROM clases");

echo "<h2>Lista de clases</h2>";
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
  echo "<p><strong>{$row['nombre']}</strong> - {$row['fecha']} a las {$row['hora']} (Cupo: {$row['cupo']})</p>";
  echo "<form action='../html/reservar.html' method='GET'>
          <input type='hidden' name='clase_id' value='{$row['id']}'>
          <button type='submit'>Reservar</button>
        </form>";
}
?>