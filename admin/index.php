<?php
    require '../config/db.php';
    $sql = "SELECT * FROM products";
    $resultado = $pdo->query($sql); // Ejecuta la consulta
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/tabla.css">
    <title>admini</title>
</head>
<body>
   <h1>Lista de Productos</h1>
   <a href="productos/crear.php">Crear Producto</a>
   <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Imagen</th>
            <th>Creado</th>
            <th>Acciones</th>
        </tr>
        <?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $fila['id']; ?></td>
            <td><?php echo $fila['name']; ?></td>
            <td><?php echo $fila['description']; ?></td>
            <td><?php echo $fila['price']; ?></td>
            <td><?php echo $fila['stock']; ?></td>
            <td><?php echo $fila['image']; ?></td>
            <td><?php echo $fila['created_at']; ?></td>
            <td>
                <a href="productos/editar.php?id=<?php echo $fila['id']; ?>">Editar</a> 
                <a href="productos/eliminar.php?id=<?php echo $fila['id']; ?>" onclick="return confirm('¿Está seguro?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
   </table>
</body>
</html>