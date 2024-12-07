<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Si no hay sesión activa, redirige al inicio de sesión
    header("Location: iniciarSesion.php");
    exit();
}

include '../../config/db.php'; // Conexión a la base de datos

// Procesar el formulario de subida
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_FILES['image'];

    // Validar y subir la imagen
    if ($image['error'] === UPLOAD_ERR_OK) {
        $imageName = uniqid() . '_' . basename($image['name']); // Generar un nombre único
        $uploadDir = '../../images/'; // Directorio de subida
        $uploadPath = $uploadDir . $imageName;

        if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
            try {
                // Insertar el producto en la base de datos
                $sql = "INSERT INTO products (name, description, price, stock, image) VALUES (:name, :description, :price, :stock, :image)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':description' => $description,
                    ':price' => $price,
                    ':stock' => $stock,
                    ':image' => $imageName,
                ]);
                echo "Producto agregado exitosamente.";
            } catch (PDOException $e) {
                echo "Error al insertar producto: " . $e->getMessage();
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "Error en la imagen: " . $image['error'];
    }
}

// Obtener productos de la base de datos
try {
    $sql = "SELECT id, name, description, price, stock, image FROM products";
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener productos: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/productoNuevo.css">
    <title>Nuevo Producto</title>
</head>
<body>
<main class="products container">
    <h2>Subir un nuevo producto</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label for="name">Nombre del producto:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="description">Descripción:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <label for="price">Precio:</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>
        <div>
            <label for="stock">Cantidad:</label>
            <input type="number" id="stock" name="stock" required>
        </div>
        <div>
            <label for="image">Imagen:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit">Subir Producto</button>
    </form>
</main>
</body>
</html>
