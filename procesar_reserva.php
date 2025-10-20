<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Primero insertamos o actualizamos el usuario
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nombre, apellido, telefono, email) 
            VALUES (:nombre, :apellido, :telefono, :email)
            ON DUPLICATE KEY UPDATE 
            nombre = :nombre,
            apellido = :apellido,
            telefono = :telefono
        ");

        $stmt->execute([
            ':nombre' => $_POST['nombre'],
            ':apellido' => $_POST['apellido'],
            ':telefono' => $_POST['telefono'],
            ':email' => $_POST['email']
        ]);

        // Obtenemos el ID del usuario
        $id_usuario = $pdo->lastInsertId();
        if (!$id_usuario) {
            // Si no hay lastInsertId, significa que el usuario ya existía
            $stmt = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
            $stmt->execute([$_POST['email']]);
            $id_usuario = $stmt->fetchColumn();
        }

        // Insertamos la cita
        $stmt = $pdo->prepare("
            INSERT INTO citas (
                id_usuario, 
                id_servicio, 
                id_estilista, 
                fecha, 
                hora, 
                comentarios
            ) VALUES (
                :id_usuario,
                :id_servicio,
                :id_estilista,
                :fecha,
                :hora,
                :comentarios
            )
        ");

        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':id_servicio' => $_POST['servicio'],
            ':id_estilista' => $_POST['estilista'],
            ':fecha' => $_POST['fecha'],
            ':hora' => $_POST['hora'],
            ':comentarios' => $_POST['comentarios']
        ]);

        // Redirigir con mensaje de éxito
        header("Location: confirmacion.php?id=" . $pdo->lastInsertId());
        exit();

    } catch(PDOException $e) {
        die("Error al procesar la reserva: " . $e->getMessage());
    }
} else {
    header("Location: reservar.php");
    exit();
}
