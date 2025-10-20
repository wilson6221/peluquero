<?php
session_start();
require_once 'config/database.php';

// Manejar el cierre de sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Credenciales de ejemplo (en un caso real, deberían estar en una base de datos)
$admin_user = "admin";
$admin_pass = "admin123";

// Verificar login
if (!isset($_SESSION['admin_logged_in'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
        if ($_POST['username'] === $admin_user && $_POST['password'] === $admin_pass) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user'] = $admin_user;
        } else {
            $error = "Credenciales incorrectas";
        }
    }
}

// Procesar acciones solo si el administrador está autenticado
if (isset($_SESSION['admin_logged_in']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['id_cita'])) {
        try {
            // Obtener estado actual antes de actualizar
            $stmt = $pdo->prepare("SELECT estado FROM citas WHERE id_cita = ?");
            $stmt->execute([$_POST['id_cita']]);
            $estado_anterior = $stmt->fetchColumn();

            // Actualizar estado de la cita
            $stmt = $pdo->prepare("UPDATE citas SET estado = ? WHERE id_cita = ?");
            $stmt->execute([$_POST['action'], $_POST['id_cita']]);

            // Registrar en el historial
            $stmt = $pdo->prepare("
                INSERT INTO historial_cambios 
                (id_cita, estado_anterior, estado_nuevo, usuario_admin, comentario) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $_POST['id_cita'],
                $estado_anterior,
                $_POST['action'],
                $_SESSION['admin_user'],
                isset($_POST['comentario']) ? $_POST['comentario'] : ''
            ]);

            $mensaje = "Estado actualizado correctamente";

        } catch(PDOException $e) {
            $error = "Error al actualizar el estado: " . $e->getMessage();
        }
    }
}

// Si no está autenticado, mostrar formulario de login
if (!isset($_SESSION['admin_logged_in'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Salón de Belleza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Login Administrador</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Usuario:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    exit();
}

// Si está autenticado, mostrar panel de administración
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Salón de Belleza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-between mt-4 mb-4">
            <div class="col">
                <h2>Panel de Administración</h2>
            </div>
            <div class="col text-end">
                <a href="admin.php?logout=1" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h3>Gestión de Citas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $pdo->query("
                                    SELECT 
                                        c.*,
                                        s.nombre_servicio as servicio,
                                        CONCAT(u.nombre, ' ', u.apellido) as nombre_cliente
                                    FROM citas c
                                    JOIN servicios s ON c.id_servicio = s.id_servicio
                                    JOIN usuarios u ON c.id_usuario = u.id_usuario
                                    ORDER BY c.fecha DESC, c.hora DESC
                                ");
                                while ($row = $stmt->fetch()) {
                                    $fecha = date('d/m/Y', strtotime($row['fecha']));
                                    $hora = date('H:i', strtotime($row['hora']));
                                    
                                    echo "<tr>";
                                    echo "<td>{$row['id_cita']}</td>";
                                    echo "<td>{$row['nombre_cliente']}</td>";
                                    echo "<td>{$row['servicio']}</td>";
                                    echo "<td>{$fecha}</td>";
                                    echo "<td>{$hora}</td>";
                                    echo "<td>";
                                    switch($row['estado']) {
                                        case 'pendiente':
                                            echo '<span class="badge bg-warning" title="La cita está agendada pero aún no ha sido confirmada">Pendiente de confirmación</span>';
                                            break;
                                        case 'confirmada':
                                            echo '<span class="badge bg-success" title="La cita ha sido confirmada y está lista para atenderse">Confirmada</span>';
                                            break;
                                        case 'cancelada':
                                            echo '<span class="badge bg-danger" title="La cita fue cancelada">Cancelada</span>';
                                            break;
                                        case 'completada':
                                            echo '<span class="badge bg-info" title="El servicio ya se realizó exitosamente">Servicio realizado</span>';
                                            break;
                                        default:
                                            echo $row['estado'];
                                    }
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<form method='POST' class='d-inline'>";
                                    echo "<input type='hidden' name='id_cita' value='{$row['id_cita']}'>";
                                    
                                    // Mostrar botones según el estado actual
                                    if ($row['estado'] !== 'confirmada') {
                                        echo "<button type='submit' name='action' value='confirmada' class='btn btn-sm btn-success me-1'>Confirmar</button>";
                                    }
                                    if ($row['estado'] !== 'cancelada') {
                                        echo "<button type='submit' name='action' value='cancelada' class='btn btn-sm btn-danger me-1'>Cancelar</button>";
                                    }
                                    if ($row['estado'] !== 'completada' && $row['estado'] !== 'cancelada') {
                                        echo "<button type='submit' name='action' value='completada' class='btn btn-sm btn-primary'>Completar</button>";
                                    }
                                    
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } catch(PDOException $e) {
                                echo "<tr><td colspan='7' class='text-center text-danger'>Error al cargar las citas: " . $e->getMessage() . "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>