<?php
require_once 'config/database.php';
session_start();

// Obtener servicios
$stmt = $pdo->query("SELECT * FROM servicios WHERE activo = 1");
$servicios = $stmt->fetchAll();

// Obtener estilistas
$stmt = $pdo->query("SELECT * FROM estilistas WHERE activo = 1");
$estilistas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Cita - Beauty Salon</title>
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
                        <a class="nav-link" href="index.php">Volver al Inicio</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h2 class="text-center mb-4">Reservar Cita</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form id="reservaForm" action="procesar_reserva.php" method="POST">
                            <!-- Datos personales -->
                            <h4 class="mb-3">Datos Personales</h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <!-- Selección de servicio -->
                            <h4 class="mb-3">Seleccionar Servicio</h4>
                            <div class="mb-3">
                                <select class="form-select" id="servicio" name="servicio" required>
                                    <option value="">Seleccione un servicio</option>
                                    <?php foreach($servicios as $servicio): ?>
                                        <option value="<?php echo $servicio['id_servicio']; ?>" 
                                                data-duracion="<?php echo $servicio['duracion']; ?>">
                                            <?php echo $servicio['nombre_servicio']; ?> - 
                                            $<?php echo number_format($servicio['precio'], 2); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Selección de estilista -->
                            <h4 class="mb-3">Seleccionar Estilista</h4>
                            <div class="mb-3">
                                <select class="form-select" id="estilista" name="estilista" required>
                                    <option value="">Seleccione un estilista</option>
                                    <?php foreach($estilistas as $estilista): ?>
                                        <option value="<?php echo $estilista['id_estilista']; ?>">
                                            <?php echo $estilista['nombre'] . ' ' . $estilista['apellido']; ?> - 
                                            <?php echo $estilista['especialidad']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Fecha y hora -->
                            <h4 class="mb-3">Seleccionar Fecha y Hora</h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required 
                                           min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="hora" class="form-label">Hora</label>
                                    <select class="form-select" id="hora" name="hora" required>
                                        <option value="">Seleccione una hora</option>
                                        <?php
                                        $inicio = 9; // 9 AM
                                        $fin = 18; // 6 PM
                                        for($i = $inicio; $i <= $fin; $i++) {
                                            $hora = sprintf("%02d:00", $i);
                                            echo "<option value='$hora'>$hora</option>";
                                            
                                            // También agregamos la media hora
                                            if($i != $fin) {
                                                $hora = sprintf("%02d:30", $i);
                                                echo "<option value='$hora'>$hora</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Comentarios -->
                            <div class="mb-3">
                                <label for="comentarios" class="form-label">Comentarios adicionales</label>
                                <textarea class="form-control" id="comentarios" name="comentarios" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Confirmar Reserva</button>
                        </form>
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
