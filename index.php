<?php
require_once 'includes/header.php';
require_once 'includes/nav.php';


$productos = [
    [
        "id" => 1,
        "nombre" => "Adidas Wales Bonner",
        "precio" => 145000,
        "imagen_principal" => "img/descarga (7).jpg", 
        "imagen_hover" => "img/descarga (8).jpg",    
        "descripcion" => "Edición especial con detalles premium."
    ],
    [
        "id" => 2,
        "nombre" => "Puma Suede Mid",
        "precio" => 112000,
        "imagen_principal" => "img/descarga (6).jpg",
        "imagen_hover" => "img/descarga (5).jpg",
        "descripcion" => "Estilo retro con plataforma oculta."
    ],
    [
        "id" => 3,
        "nombre" => "Adidas Samba Lace Green",
        "precio" => 135000,
        "imagen_principal" => "img/green.jpg",
        "imagen_hover" => "img/green.jpg", 
        "descripcion" => "Diseño clásico renovado con encaje verde."
    ],
    [
        "id" => 4,
        "nombre" => "Alohas Suede Sneakers",
        "precio" => 128000,
        "imagen_principal" => "img/descarga (9).jpg",
        "imagen_hover" => "img/descarga (10).jpg", 
        "descripcion" => "Zapatillas de gamuza con detalles rústicos."
    ],
    [
        "id" => 5,
        "nombre" => "Birkenstock Boston Suede",
        "precio" => 155000,
        "imagen_principal" => "img/zandalias.jpg",
        "imagen_hover" => "img/Boston Birkenstock.jpg",
        "descripcion" => "Zuecos de gamuza super cómodos."
    ],
    [
        "id" => 6,
        "nombre" => "Nike Cortez Vintage",
        "precio" => 142000,
        "imagen_principal" => "img/descarga (4).jpg",
        "imagen_hover" => "img/descarga (4).jpg",
        "descripcion" => "El clásico de running reinventado para la calle."
    ]
];
?>

<main style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <h2 style="text-align: center;">Últimos Ingresos</h2>
    <p style="text-align: center; color: #555; margin-bottom: 30px;">
        Descubre nuestra nueva colección de zapatillas.
    </p>

    <div class="contenedorProdu">
        <?php foreach ($productos as $item): ?>
            <div class="tarjetaProdu">
              
                <div class="imagenWrapper">
                    <img class="img-principal" src="<?php echo htmlspecialchars($item['imagen_principal']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>">
                    <img class="img-hover" src="<?php echo htmlspecialchars($item['imagen_hover']); ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?> puesta">
                </div>
                
                <h3><?php echo htmlspecialchars($item['nombre']); ?></h3>
                <p class="desc"><?php echo htmlspecialchars($item['descripcion']); ?></p>
                <p class="precio">$<?php echo number_format($item['precio'], 2, ',', '.'); ?></p>
                <?php if (isset($_SESSION['usuario_id'])): ?>
    
                <button onclick="alert('¡<?php echo htmlspecialchars($item['nombre']); ?> añadido al carrito con éxito!')">
                    Añadir al carrito
                </button>
                <?php else: ?>
   
                <button onclick="alert('Por favor, inicia sesión para añadir productos al carrito.')">
                Añadir al carrito
                </button>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>