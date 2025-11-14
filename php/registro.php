<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)");
$stmt->bindValue(1, $nombre);
$stmt->bindValue(2, $correo);
$stmt->bindValue(3, $contraseña);

if ($stmt->execute()) {
  echo "Registro exitoso.";
} else {
  echo "Error al registrar.";
}
?>