<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Shop - Estilo y Tradición</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #c19a6b;
            --secondary-color: #2c1810;
            --dark-brown: #3d2817;
            --light-tan: #d4af37;
            --cream: #f5f5dc;
        }

        body {
            font-family: 'Arial', sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--dark-brown) 100%) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .navbar-brand {
            font-weight: bold;
            color: var(--light-tan) !important;
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav-link {
            color: var(--cream) !important;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: var(--light-tan) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--light-tan) 100%);
            border: none;
            color: var(--secondary-color);
            font-weight: bold;
            transition: transform 0.3s;
        }

        .btn-primary:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, var(--light-tan) 0%, var(--primary-color) 100%);
        }

        .hero {
            background: linear-gradient(rgba(44, 24, 16, 0.8), rgba(61, 40, 23, 0.9)), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%233d2817" width="1200" height="600"/><path fill="%232c1810" d="M0 300 L300 0 L600 300 L900 0 L1200 300 L1200 600 L0 600 Z"/></svg>');
            background-size: cover;
            background-position: center;
            min-height: 500px;
            display: flex;
            align-items: center;
            border-bottom: 5px solid var(--light-tan);
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.7);
            color: var(--cream);
        }

        .hero .lead {
            font-size: 1.3rem;
            color: var(--light-tan);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .card {
            border: 2px solid var(--primary-color);
            box-shadow: 0 4px 15px rgba(193, 154, 107, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(193, 154, 107, 0.5);
        }

        .card-title {
            color: var(--dark-brown);
            font-weight: bold;
        }

        .text-primary {
            color: var(--light-tan) !important;
            font-weight: bold;
        }

        #servicios h2, #estilistas h2 {
            color: var(--dark-brown);
            font-weight: bold;
            position: relative;
            padding-bottom: 15px;
        }

        #servicios h2:after, #estilistas h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--light-tan), transparent);
        }

        .bg-light {
            background: linear-gradient(135deg, #f5f5dc 0%, #ede4d3 100%) !important;
        }

        footer {
            background: linear-gradient(135deg, var(--secondary-color) 0%, var(--dark-brown) 100%);
            border-top: 4px solid var(--light-tan);
        }

        footer h5 {
            color: var(--light-tan);
            font-weight: bold;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--dark-brown) 0%, var(--secondary-color) 100%);
            color: var(--cream);
        }

        .modal-title {
            color: var(--light-tan);
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        .rounded-circle {
            border: 4px solid var(--light-tan);
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
            border-bottom: 3px solid var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-cut"></i> Barbería Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#inicio">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicios">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#estilistas">Barberos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="consultar_reserva.php">Consultar Reserva</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary ms-2" href="reservar.php">Reservar Cita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-2" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-user-shield"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center text-white">
                    <h1 class="display-4">
                        <i class="fas fa-scissors"></i> Barbería Shop
                    </h1>
                    <p class="lead">Tradición, estilo y el mejor servicio profesional para el hombre moderno</p>
                    <a href="reservar.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-calendar-check"></i> Reservar Cita
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Servicios -->
    <section id="servicios" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Nuestros Servicios</h2>
            <div class="row">
                <?php
                require_once 'config/database.php';
                $stmt = $pdo->query("SELECT * FROM servicios WHERE activo = 1");
                while($servicio = $stmt->fetch()) {
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="assets/img/servicios/' . (empty($servicio['imagen']) ? 'default.jpg' : $servicio['imagen']) . '" class="card-img-top" alt="' . $servicio['nombre_servicio'] . '">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-cut"></i> ' . $servicio['nombre_servicio'] . '</h5>
                                <p class="card-text">' . $servicio['descripcion'] . '</p>
                                <p class="card-text"><small class="text-muted"><i class="far fa-clock"></i> Duración: ' . $servicio['duracion'] . ' minutos</small></p>
                                <h6 class="card-subtitle mb-2 text-primary">$' . number_format($servicio['precio'], 2) . '</h6>
                                <a href="reservar.php?servicio=' . $servicio['id_servicio'] . '" class="btn btn-primary w-100">
                                    <i class="fas fa-calendar-plus"></i> Reservar
                                </a>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Estilistas -->
    <section id="estilistas" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Nuestros Barberos Profesionales</h2>
            <div class="row">
                <?php
                $stmt = $pdo->query("SELECT * FROM estilistas WHERE activo = 1");
                while($estilista = $stmt->fetch()) {
                    echo '
                    <div class="col-md-3 mb-4">
                        <div class="card text-center h-100">
                            <img src="assets/img/estilistas/default.jpg" class="card-img-top rounded-circle mx-auto mt-3" style="width: 150px; height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">' . $estilista['nombre'] . ' ' . $estilista['apellido'] . '</h5>
                                <p class="card-text"><i class="fas fa-star text-warning"></i> ' . $estilista['especialidad'] . '</p>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-cut"></i> Barbería Shop</h5>
                    <p>Tradición y estilo desde 1950</p>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p>
                        <i class="fas fa-phone"></i> (123) 456-7890<br>
                        <i class="fas fa-envelope"></i> info@barberiaclasica.com<br>
                        <i class="fas fa-map-marker-alt"></i> Calle Principal #123
                    </p>
                </div>
                <div class="col-md-4">
                    <h5>Síguenos</h5>
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                    <div class="mt-3">
                        <button type="button" class="btn btn-link text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-lock"></i> Acceso Administrador
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">
                        <i class="fas fa-user-shield"></i> Acceso Administrador
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="admin.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>