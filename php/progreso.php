<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$correo = $_POST['correo'];
$fecha = $_POST['fecha'];
$peso = $_POST['peso'];
$cintura = $_POST['cintura'];
$pecho = $_POST['pecho'];

$stmt = $db->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bindValue(1, $correo);
$result = $stmt->execute();
$usuario = $result->fetchArray(SQLITE3_ASSOC);

if ($usuario) {
  $usuario_id = $usuario['id'];

  $insert = $db->prepare("INSERT INTO progreso (usuario_id, fecha, peso, cintura, pecho) VALUES (?, ?, ?, ?, ?)");
  $insert->bindValue(1, $usuario_id);
  $insert->bindValue(2, $fecha);
  $insert->bindValue(3, $peso);
  $insert->bindValue(4, $cintura);
  $insert->bindValue(5, $pecho);
  $insert->execute();

  // Mostrar historial
  $historial = $db->prepare("SELECT fecha, peso, cintura, pecho FROM progreso WHERE usuario_id = ? ORDER BY fecha DESC");
  $historial->bindValue(1, $usuario_id);
  $res = $historial->execute();

  echo "<h2>Historial de progreso</h2><table border='1' cellpadding='8'><tr><th>Fecha</th><th>Peso</th><th>Cintura</th><th>Pecho</th></tr>";
  while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    echo "<tr><td>{$row['fecha']}</td><td>{$row['peso']} kg</td><td>{$row['cintura']} cm</td><td>{$row['pecho']} cm</td></tr>";
  }
  echo "</table>";
} else {
  echo "Usuario no encontrado.";
}
?>