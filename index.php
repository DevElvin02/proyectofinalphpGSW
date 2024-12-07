<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Si no hay sesión activa, redirige al inicio de sesión
    header("Location: iniciarSesion.php");
    exit();
}

include 'config/db.php'; // Conexión a la base de datos

// Obtener productos de la base de datos
try {
    $sql = "SELECT id, name, description, price, image FROM products"; // Ajusta los nombres de las columnas según tu base de datos
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener productos: " . $e->getMessage();
    exit();
}
?>

<?php
    include 'include/header.php';
?>
<header class="header">
    <div class="menu container">
        <a href="#" class="logo">
            <img src="images/logo_large.png" alt="logo" class="logo-img"></a>
        <input type="checkbox" id="menu"/>
        <label for="menu">
            <img src="images/menu.png" class="menu-icono" alt="menu hamburguesa">
        </label>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="index.html">Nosotros</a></li>
                <li><a href="#lista-1">Productos</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
        <div>
            <br>
            <a class="cerrarSesion" href="logout.php">Cerrar sesión</a>
            <ul>
                <li class="submenu">
                    <img src="images/car.svg" id="img-carrito" alt="carrito">
                    <div id="carrito">
                        <table id="lista-carrito">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <a href="#" id="vaciar-carrito" class="btn-2">Vaciar carrito</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="header-content container">
            <div class="heade-img">
                <img src="images/right.png" alt="">
            </div>
            <div class="header-txt">
                <h1>Diseños especiales</h1>
                <p>Donde tus ideas toman forma!</p>
                <a href="#" class="btn-1">Informacion</a>
            </div>
        </div>

</header>

<section class="ofert container">
        <div class="ofert-1">
            <div class="ofert-img">
                <img src="images/f1.png" alt="">
            </div>
            <div class="ofert-txt">
                <h3>Graduaciones</h3>
                <a href="#" class="btn-2">Informacion</a>
            </div>
        </div>

        <div class="ofert-1">
            <div class="ofert-img">
                <img src="images/f2.png" alt="">
            </div>
            <div class="ofert-txt">
                <h3>Cumpleaños</h3>
                <a href="#" class="btn-2">Informacion</a>
            </div>
        </div>

        <div class="ofert-1">
            <div class="ofert-img">
                <img src="images/f3.png" alt="">
            </div>
            <div class="ofert-txt">
                <h3>Bautizos</h3>
                <a href="#" class="btn-2">Informacion</a>
            </div>
        </div>
    </section>

<main class="products container" id="lista-1">
    <h2>Nuestros productos disponibles</h2>
    <div class="product-content">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <div class="product-txt">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <p class="precio">$<?php echo number_format($product['price'], 2); ?></p>
                    <a href="#" class="agregar-carrito btn-2" data-id="<?php echo $product['id']; ?>">Agregar al carrito</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
 <br>
 <br>
<section class=" container">
        <div class="icon-1">
            <div class="icon-img">
                <img src="images/i1.svg" alt="">
            </div>
            <div class="icon-txt">
                <h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat quidem architecto itaque blanditiis facere necessitatibus, quod vitae tenetur sapiente sint!</h3>
                <p>
                    venta de  productos de uso personal ...
                </p>
            </div>
        </div>

        <div class="icon-1">
            <div class="icon-img">
                <img src="images/i2.svg" alt="">
            </div>
            <div class="icon-txt">
                <h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat quidem architecto itaque blanditiis facere necessitatibus, quod vitae tenetur sapiente sint!</h3>
                <p>
                    venda de  productos de uso personal
                </p>
            </div>
        </div>

        <div class="icon-1">
        <div class="icon-img">
            <img src="images/i3.svg" alt="">
        </div>

        <div class="icon-txt">
            <h3>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat quidem architecto itaque blanditiis facere necessitatibus, quod vitae tenetur sapiente sint!</h3>
            <p>
                venta de  productos de uso personal
            </p>
         </div>
        </div>

    </section>
    <section class="blog container">
        <div class="blog-1">
            <img src="images/b1.jpg" alt="">
            <h3>Blog 1</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla commodi nisi quasi impedit consectetur assumenda a illum, quisquam facilis architecto?
            </p>
        </div>
        <div class="blog-1">
            <img src="images/b2.jpg" alt="">
            <h3>Blog 2</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla commodi nisi quasi impedit consectetur assumenda a illum, quisquam facilis architecto?
            </p>
        </div>
        <div class="blog-1">
            <img src="images/b3.jpg" alt="">
            <h3>Blog 3</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla commodi nisi quasi impedit consectetur assumenda a illum, quisquam facilis architecto?
            </p>
        </div>
    </section>

<?php
    include 'include/footer.php';
?>