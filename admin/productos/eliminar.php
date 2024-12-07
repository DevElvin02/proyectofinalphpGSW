<?php
    require '../../config/db.php';

    // Obtener el ID desde el parámetro GET
    $id = $_GET['id'];

try {
    // Preparar la consulta SQL
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    // Vincular el parámetro y ejecutar la consulta
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        // Redirigir al index después de eliminar
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al eliminar la taza.";
    }
} catch (PDOException $e) {
    // Manejar errores de la base de datos
    echo "Error: " . $e->getMessage();
}
?>
