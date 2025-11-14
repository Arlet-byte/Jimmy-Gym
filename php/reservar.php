<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$clase_id = $_POST['clase_id'];
$correo = $_POST['correo'];

// Buscar usuario
$stmt = $db->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bindValue(1, $correo);
$result = $stmt->execute();
$usuario = $result->fetchArray(SQLITE3_ASSOC);

if ($usuario) {
  $usuario_id = $usuario['id'];

  // Verificar cupo
  $stmt2 = $db->prepare("SELECT cupo FROM clases WHERE id = ?");
  $stmt2->bindValue(1, $clase_id);
  $result2 = $stmt2->execute();
  $clase = $result2->fetchArray(SQLITE3_ASSOC);

  // Contar reservas
  $stmt3 = $db->prepare("SELECT COUNT(*) as total FROM reservas WHERE clase_id = ?");
  $stmt3->bindValue(1, $clase_id);
  $result3 = $stmt3->execute();
  $reservas = $result3->fetchArray(SQLITE3_ASSOC);

  if ($reservas['total'] < $clase['cupo']) {
    // Insertar reservación
    $stmt4 = $db->prepare("INSERT INTO reservas (usuario_id, clase_id, confirmada) VALUES (?, ?, 1)");
    $stmt4->bindValue(1, $usuario_id);
    $stmt4->bindValue(2, $clase_id);
    $stmt4->execute();
    header("Location: ../html/mensaje.html?msg=reservado");
  } else {
    header("Location: ../html/mensaje.html?msg=cupo_lleno");
  }
} else {
  header("Location: ../html/mensaje.html?msg=usuario_no_encontrado");
}
?>