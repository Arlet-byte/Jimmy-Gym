<?php
session_start();
include 'conexion.php';

$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

$stmt = $db->prepare("SELECT * FROM usuarios WHERE correo = ?");
$stmt->bindValue(1, $correo);
$result = $stmt->execute();
$usuario = $result->fetchArray(SQLITE3_ASSOC);

if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
  $_SESSION['usuario_id'] = $usuario['id'];
  $_SESSION['correo'] = $usuario['correo'];
  header("Location: ../html/dashboard.html");
  exit();
} else {
  header("Location: ../html/mensaje.html?msg=login_error");
  exit();
}
?>