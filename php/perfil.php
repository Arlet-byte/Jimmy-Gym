<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
  header("Location: ../html/login.html");
  exit();
}

$correo = $_POST['correo'];
$peso = $_POST['peso'];
$altura = $_POST['altura'];
$objetivo = $_POST['objetivo'];

$stmt = $db->prepare("UPDATE usuarios SET peso = ?, altura = ?, objetivo = ? WHERE correo = ?");
$stmt->bindValue(1, $peso);
$stmt->bindValue(2, $altura);
$stmt->bindValue(3, $objetivo);
$stmt->bindValue(4, $correo);

if ($stmt->execute()) {
  echo "Perfil actualizado correctamente.";
} else {
  echo "Error al actualizar perfil.";
}

function obtenerRutinaPorObjetivo($objetivo) {
  switch (strtolower(trim($objetivo))) {
    case 'bajar grasa':
      return "Lunes: Cardio HIIT\nMartes: Piernas + abdominales\nMiércoles: Descanso\nJueves: Circuito full body\nViernes: Cardio + core\nSábado: Yoga o caminata\nDomingo: Descanso";
    case 'ganar masa':
    case 'ganar masa muscular':
      return "Lunes: Pecho + tríceps\nMartes: Espalda + bíceps\nMiércoles: Piernas\nJueves: Hombros + abdomen\nViernes: Full body pesado\nSábado: Cardio ligero\nDomingo: Descanso";
    case 'mantener condición':
      return "Lunes: Full body funcional\nMartes: Cardio + core\nMiércoles: Fuerza ligera\nJueves: Yoga o movilidad\nViernes: HIIT suave\nSábado: Caminata larga\nDomingo: Descanso";
    default:
      return null;
  }
}

$rutina = obtenerRutinaPorObjetivo($objetivo);

if ($rutina) {
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
  } else {
    $insert = $db->prepare("INSERT INTO rutinas (usuario_id, descripcion) VALUES (?, ?)");
    $insert->bindValue(1, $usuario_id);
    $insert->bindValue(2, $rutina);
    $insert->execute();
  }
}
?>