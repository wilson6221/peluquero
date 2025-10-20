<?php
require_once 'config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

try {
    $stmt = $pdo->prepare("
        SELECT c.*, u.nombre, u.apellido, u.email, u.telefono,
               s.nombre_servicio, s.precio,
               e.nombre as estilista_nombre, e.apellido as estilista_apellido
        FROM citas c
        JOIN usuarios u ON c.id_usuario = u.id_usuario
        JOIN servicios s ON c.id_servicio = s.id_servicio
        JOIN estilistas e ON c.id_estilista = e.id_estilista
        WHERE c.id_cita = ?
    ");
    
    $stmt->execute([$_GET['id']]);
    $cita = $stmt->fetch();

    if (!$cita) {
        header("Location: index.php");
        exit();
    }
} catch(PDOException $e) {
    die("Error al obtener los detalles de la cita: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reserva - Beauty Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Beauty Salon</a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        <h2 class="my-4">¡Reserva Confirmada!</h2>
                        
                        <div class="alert alert-info mb-4">
                            <h3 class="alert-heading">Número de Reserva: #<?php echo $cita['id_cita']; ?></h3>
                            <hr>
                            <p class="mb-0">
                                <strong>¡Importante!</strong> Guarda este número para consultar el estado de tu reserva.
                                Puedes verificar el estado en cualquier momento en la sección 
                                <a href="consultar_reserva.php" class="alert-link">Consultar Reserva</a>.
                            </p>
                        </div>

                        <div class="text-start">
                            <h4 class="mb-3">Detalles de la Reserva:</h4>
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
                                <li class="list-group-item">
                                    <strong>Precio:</strong> $<?php echo number_format($cita['precio'], 2); ?>
                                </li>
                            </ul>

                            <div class="alert alert-info mt-4">
                                <i class="fas fa-info-circle"></i> Se ha enviado un correo de confirmación a: <?php echo htmlspecialchars($cita['email']); ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="index.php" class="btn btn-primary">Volver al Inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Beauty Salon</h5>
                    <p>Tu mejor versión comienza aquí</p>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p>
                        <i class="fas fa-phone"></i> (123) 456-7890<br>
                        <i class="fas fa-envelope"></i> info@beautysalon.com<br>
                        <i class="fas fa-map-marker-alt"></i> Calle Principal #123
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Síguenos</h5>
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
