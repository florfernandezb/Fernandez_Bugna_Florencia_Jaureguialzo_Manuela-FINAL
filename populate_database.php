<?php
/**
 * Script para poblar la base de datos con datos iniciales
 * Ejecutar una sola vez desde el navegador: http://localhost/Fernandez_Bugna_Florencia_Jaureguialzo_Manuela-PARCIAL_2/populate_database.php
 */

require_once __DIR__ . '/class/DatabaseConection.php';
require_once __DIR__ . '/class/Products.php';
require_once __DIR__ . '/class/Categories.php';
require_once __DIR__ . '/class/Colors.php';

// Conectar a la base de datos
$db = DatabaseConection::getConection();

try {
    $db->beginTransaction();

    echo "<h1>Poblando base de datos...</h1>";

    // 1. Insertar categorías
    echo "<h2>1. Insertando categorías...</h2>";
    $categories = ['bowls', 'tazas', 'fuentes', 'mates', 'platos', 'macetas'];
    $categoryMap = [];
    
    $categoriesObj = new Categories();
    foreach ($categories as $categoryName) {
        $categoryId = $categoriesObj->createCategory($categoryName);
        $categoryMap[$categoryName] = $categoryId;
        echo "✓ Categoría '$categoryName' creada (ID: $categoryId)<br>";
    }

    // 2. Insertar colores
    echo "<h2>2. Insertando colores...</h2>";
    $colors = ['negro', 'gris', 'blanco', 'beige', 'crema'];
    $colorMap = [];
    
    $colorsObj = new Colors();
    foreach ($colors as $colorName) {
        $colorId = $colorsObj->createColor($colorName);
        $colorMap[$colorName] = $colorId;
        echo "✓ Color '$colorName' creado (ID: $colorId)<br>";
    }

    // 3. Insertar productos desde JSON
    echo "<h2>3. Insertando productos...</h2>";
    $jsonFile = __DIR__ . '/data/productos.json';
    $productsData = json_decode(file_get_contents($jsonFile), true);
    
    $productsObj = new Products();
    
    foreach ($productsData as $product) {
        // Convertir fecha de DD/MM/YYYY a YYYY-MM-DD
        $dateParts = explode('/', $product['availableDate']);
        $availableDate = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
        
        // Guardar solo el nombre de la imagen (sin ruta ni extensión)
        // Las vistas ya agregan './res/products/' y '.png'
        $image = $product['image'];
        
        // Corregir mayúsculas/minúsculas si es necesario
        if ($image === 'MacetaFlorencia') {
            $image = 'macetaFlorencia';
        }
        
        // Escapar comillas simples en las descripciones
        $productDescription = str_replace("'", "\\'", $product['productDescription']);
        $imageDescription = str_replace("'", "\\'", $product['imageDescription']);
        
        // Crear producto
        $productId = $productsObj->createProduct(
            $product['name'],
            $product['price'],
            $availableDate,
            $productDescription,
            $image,
            $imageDescription,
            $product['measurements']
        );
        
        echo "✓ Producto '{$product['name']}' creado (ID: $productId)<br>";
        
        // Asociar producto con categoría
        $categoryName = $product['category'];
        if (isset($categoryMap[$categoryName])) {
            $productsObj->add_product_x_category($productId, $categoryMap[$categoryName]);
            echo "  → Asociado con categoría '$categoryName'<br>";
        }
        
        // Asociar producto con colores (extraer de imageDescription)
        $imageDesc = strtolower($product['imageDescription']);
        foreach ($colorMap as $colorName => $colorId) {
            if (strpos($imageDesc, $colorName) !== false) {
                $stmt = $db->prepare("INSERT INTO product_x_color (product_id, color_id) VALUES (?, ?)");
                $stmt->execute([$productId, $colorId]);
                echo "  → Asociado con color '$colorName'<br>";
            }
        }
    }

    // 4. Insertar usuarios
    echo "<h2>4. Insertando usuarios...</h2>";
    $users = [
        [
            'email' => 'florencia.fernandezb@davinci.edu.ar',
            'username' => 'florenciafernandezb',
            'full_name' => 'Florencia Fernández',
            'password' => 'asd123',
            'role' => 'superadmin'
        ],
        [
            'email' => 'manuela.jaureguialzo@davinci.edu.ar',
            'username' => 'manu',
            'full_name' => 'Manuela Jaureguialzo',
            'password' => '1410',
            'role' => 'user'
        ],
        [
            'email' => 'jorge.perez@davinci.edu.ar',
            'username' => 'jorgepe',
            'full_name' => 'Jorge Perez',
            'password' => 'jorge1234',
            'role' => 'admin'
        ]
    ];
    
    foreach ($users as $user) {
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (email, username, full_name, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $user['email'],
            $user['username'],
            $user['full_name'],
            $hashedPassword,
            $user['role']
        ]);
        echo "✓ Usuario '{$user['username']}' creado<br>";
    }

    $db->commit();
    echo "<h2 style='color: green;'>✓ Base de datos poblada exitosamente!</h2>";
    echo "<p><a href='index.php'>Ir al sitio</a></p>";

} catch (Exception $e) {
    $db->rollBack();
    echo "<h2 style='color: red;'>✗ Error: " . $e->getMessage() . "</h2>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
