<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Validar si hay acción en el carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $cantidad = $_POST['cantidad'] ?? 1;
    $accion = $_POST['accion'];

    switch ($accion) {
        case 'agregar':
            // Buscar si el producto ya está en el carrito
            $existe = false;
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['id'] == $id) {
                    $item['cantidad'] += $cantidad;
                    $existe = true;
                    break;
                }
            }

            if (!$existe) {
                $_SESSION['carrito'][] = [
                    'id' => $id,
                    'name' => $name,
                    'price' => $price,
                    'image' => $image,
                    'cantidad' => $cantidad,
                ];
            }
            break;

        case 'eliminar':
            // Eliminar producto del carrito
            foreach ($_SESSION['carrito'] as $indice => $item) {
                if ($item['id'] == $id) {
                    unset($_SESSION['carrito'][$indice]);
                    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                    break;
                }
            }
            break;

        case 'vaciar':
            $_SESSION['carrito'] = [];
            break;
    }
}

header('Location: carrito.php');
exit();
?>