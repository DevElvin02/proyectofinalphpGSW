<?php
include '../../config/db.php';

$id = $_GET['id'];

try {
    // Preparar la consulta para obtener los datos del producto
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $taza = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$taza) {
        echo "Producto no encontrado.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error al obtener el producto: " . $e->getMessage();
    exit();
}

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['name'];
    $descripcion = $_POST['description'];
    $precio = $_POST['price'];
    $stock = $_POST['stock'];
    $imagen = $taza['image']; // Mantener la imagen actual por defecto

    // Procesar la nueva imagen si se sube
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $directorioImagenes = '../../images/';
        $nombreImagen = uniqid() . '_' . basename($_FILES['image']['name']);
        $rutaImagen = $directorioImagenes . $nombreImagen;

        // Mover la imagen subida al directorio de imágenes
        if (move_uploaded_file($_FILES['image']['tmp_name'], $rutaImagen)) {
            $imagen = $nombreImagen; // Actualizar el nombre de la imagen
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    }

    try {
        // Preparar la consulta para actualizar los datos del producto
        $sql = "UPDATE products SET name = :nombre, description = :descripcion, price = :precio, stock = :stock, image = :imagen WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Redirigir al index si se actualizó correctamente
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error al actualizar el producto.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/editar.css">
    <title>Editar Taza</title>
</head>
<body>
    <h1>Editar Producto</h1>
    <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($taza['name']); ?>" required><br>
        <label>Descripción:</label><br>
        <textarea name="description"><?php echo htmlspecialchars($taza['description']); ?></textarea><br>
        <label>Precio:</label><br>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($taza['price']); ?>" required><br>
        <label>Stock:</label><br>
        <input type="number" name="stock" value="<?php echo htmlspecialchars($taza['stock']); ?>" required><br>
        <label>Imagen actual:</label><br>
        <img src="../../images/<?php echo htmlspecialchars($taza['image']); ?>" alt="Imagen del producto" width="100"><br>
        <label>Nueva imagen:</label><br>
        <input type="file" name="image"><br><br>
        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>