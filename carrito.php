<?php
session_start();

// Verificar si hay productos en el carrito
$carrito = $_SESSION['carrito'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de compras</title>
</head>
<body>
    <h1>Carrito de compras</h1>
    <?php if (!empty($carrito)): ?>
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carrito as $producto): ?>
                    <?php $subtotal = $producto['price'] * $producto['cantidad']; ?>
                    <?php $total += $subtotal; ?>
                    <tr>
                        <td><img src="images/<?php echo htmlspecialchars($producto['image']); ?>" width="50"></td>
                        <td><?php echo htmlspecialchars($producto['name']); ?></td>
                        <td>$<?php echo number_format($producto['price'], 2); ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td>$<?php echo number_format($subtotal, 2); ?></td>
                        <td>
                            <form method="POST" action="procesar_carrito.php">
                                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                <input type="hidden" name="accion" value="eliminar">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: $<?php echo number_format($total, 2); ?></h3>
        <form method="POST" action="procesar_carrito.php">
            <input type="hidden" name="accion" value="vaciar">
            <button type="submit">Vaciar carrito</button>
        </form>
        <a href="pago.php" class="btn">Continuar con el pago</a>
    <?php else: ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>
</body>
</html>