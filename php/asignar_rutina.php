<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$correo = $_POST['correo'];
$rutina = $_POST['descripcion'];

$stmt = $db->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bindValue(1, $correo);
$result = $stmt->execute();
$usuario = $result->fetchArray(SQLITE3_ASSOC);

if ($usuario) {
  $usuario_id = $usuario['id'];

  // Verificar si ya tiene rutina
  $check = $db->prepare("SELECT id FROM rutinas WHERE usuario_id = ?");
  $check->bindValue(1, $usuario_id);
  $res = $check->execute();
  $existe = $res->fetchArray(SQLITE3_ASSOC);

  if ($existe) {
    $update = $db->prepare("UPDATE rutinas SET descripcion = ? WHERE usuario_id = ?");
    $update->bindValue(1, $rutina);
    $update->bindValue(2, $usuario_id);
    $update->execute();
    header("Location: ../html/mensaje.html?msg=rutina_actualizada");
  } else {
    $insert = $db->prepare("INSERT INTO rutinas (usuario_id, descripcion) VALUES (?, ?)");
    $insert->bindValue(1, $usuario_id);
    $insert->bindValue(2, $rutina);
    $insert->execute();
    header("Location: ../html/mensaje.html?msg=rutina_asignada");
  }
} else {
  header("Location: ../html/mensaje.html?msg=usuario_no_encontrado");
}
?>