<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$correo = $_POST['correo'];
$fecha = date("Y-m-d");
$hora = date("H:i:s");

// Buscar usuario
$stmt = $db->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bindValue(1, $correo);
$result = $stmt->execute();
$usuario = $result->fetchArray(SQLITE3_ASSOC);

if ($usuario) {
  $usuario_id = $usuario['id'];

  // Verificar membresía activa
  $check = $db->prepare("SELECT * FROM membresias WHERE usuario_id = ? AND fecha_inicio <= ? AND fecha_fin >= ?");
  $check->bindValue(1, $usuario_id);
  $check->bindValue(2, $fecha);
  $check->bindValue(3, $fecha);
  $res = $check->execute();
  $membresia = $res->fetchArray(SQLITE3_ASSOC);

  if ($membresia) {
    // Registrar asistencia
    $insert = $db->prepare("INSERT INTO asistencia (usuario_id, fecha, hora) VALUES (?, ?, ?)");
    $insert->bindValue(1, $usuario_id);
    $insert->bindValue(2, $fecha);
    $insert->bindValue(3, $hora);
    $insert->execute();

    // Mostrar historial
    $historial = $db->prepare("SELECT fecha, hora FROM asistencia WHERE usuario_id = ? ORDER BY fecha DESC");
    $historial->bindValue(1, $usuario_id);
    $res = $historial->execute();

    echo "<h2>Historial de asistencia</h2><table border='1' cellpadding='8'><tr><th>Fecha</th><th>Hora</th></tr>";
    while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
      echo "<tr><td>{$row['fecha']}</td><td>{$row['hora']}</td></tr>";
    }
    echo "</table>";
  } else {
    header("Location: ../html/mensaje.html?msg=sin_membresia");
  }
} else {
  header("Location: ../html/mensaje.html?msg=usuario_no_encontrado");
}
?>