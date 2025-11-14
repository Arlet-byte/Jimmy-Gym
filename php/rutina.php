<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$correo = $_POST['correo'];

$stmt = $db->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bindValue(1, $correo);
$result = $stmt->execute();
$usuario = $result->fetchArray(SQLITE3_ASSOC);

if ($usuario) {
  $usuario_id = $usuario['id'];

  $stmt2 = $db->prepare("SELECT descripcion FROM rutinas WHERE usuario_id = ?");
  $stmt2->bindValue(1, $usuario_id);
  $result2 = $stmt2->execute();
  $rutina = $result2->fetchArray(SQLITE3_ASSOC);

  if ($rutina) {
    echo "<h2>Tu rutina:</h2><p>" . nl2br($rutina['descripcion']) . "</p>";
  } else {
    echo "No tienes una rutina asignada aún.";
  }
} else {
  echo "Usuario no encontrado.";
}
?>