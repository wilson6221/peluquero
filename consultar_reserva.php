<?php
require_once 'config/database.php';
session_start();

$mensaje = '';
$cita = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cita'])) {
    try {
        $stmt = $pdo->prepare("
            SELECT c.*, u.nombre, u.apellido, u.email, u.telefono,
                   s.nombre_servicio, s.precio,
                   e.nombre as estilista_nombre, e.apellido as estilista_apellido
            FROM citas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            JOIN servicios s ON c.id_servicio = s.id_servicio
            JOIN estilistas e ON c.id_estilista = e.id_estilista
            WHERE c.id_cita = ? AND u.email = ?
        ");
        
        $stmt->execute([$_POST['id_cita'], $_POST['email']]);
        $cita = $stmt->fetch();

        if (!$cita) {
            $mensaje = 'No se encontró la reserva con los datos proporcionados.';
        }
    } catch(PDOException $e) {
        $mensaje = "Error al consultar la reserva: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Reserva - Beauty Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Beauty Salon</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservar.php">Reservar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Consultar Estado de Reserva</h3>
                        
                        <?php if (!$cita): ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="id_cita" class="form-label">Número de Reserva</label>
                                    <input type="number" class="form-control" id="id_cita" name="id_cita" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email registrado</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Consultar Reserva</button>
                            </form>

                            <?php if ($mensaje): ?>
                                <div class="alert alert-danger mt-3">
                                    <?php echo htmlspecialchars($mensaje); ?>
                                </div>
                            <?php endif; ?>

                        <?php else: ?>
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="mb-0">Detalles de la Reserva #<?php echo $cita['id_cita']; ?></h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Estado: </strong>
                                        <?php
                                        $estado_class = [
                                            'pendiente' => 'text-warning',
                                            'confirmada' => 'text-success',
                                            'cancelada' => 'text-danger',
                                            'completada' => 'text-info'
                                        ];
                                        ?>
                                        <span class="<?php echo $estado_class[$cita['estado']]; ?>">
                                            <?php echo ucfirst($cita['estado']); ?>
                                        </span>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Cliente:</strong> <?php echo htmlspecialchars($cita['nombre'] . ' ' . $cita['apellido']); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Servicio:</strong> <?php echo htmlspecialchars($cita['nombre_servicio']); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Estilista:</strong> <?php echo htmlspecialchars($cita['estilista_nombre'] . ' ' . $cita['estilista_apellido']); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($cita['fecha'])); ?>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Hora:</strong> <?php echo date('H:i', strtotime($cita['hora'])); ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <a href="consultar_reserva.php" class="btn btn-primary">Consultar otra reserva</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>Beauty Salon - Tu mejor versión comienza aquí</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
