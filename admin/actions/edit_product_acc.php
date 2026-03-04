<?PHP
require_once "../../functions/autoload.php";
require_once "../../functions/auth_helpers.php";

require_admin_and_redirect();

$postData = $_POST;
$id = $_GET['id'] ?? null;

try {

    $product = new Products();

    $imageBase = $postData['current_image'] ?? '';
    if (!empty($_FILES['image']) && is_array($_FILES['image']) && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        if (($_FILES['image']['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen.");
        }

        $ext = strtolower(pathinfo($_FILES['image']['name'] ?? '', PATHINFO_EXTENSION));
        if (!in_array($ext, ['png', 'jpg', 'jpeg'])) {
            throw new Exception("La imagen debe ser PNG o JPG.");
        }
        // Normalizar jpeg a jpg
        if ($ext === 'jpeg') {
            $ext = 'jpg';
        }

        $originalBase = pathinfo($_FILES['image']['name'] ?? 'producto', PATHINFO_FILENAME);
        $safeBase = preg_replace('/[^a-zA-Z0-9_-]+/', '_', $originalBase);
        $safeBase = trim($safeBase, '_');
        if ($safeBase === '') {
            $safeBase = 'producto_' . time();
        }

        $targetDir = realpath(__DIR__ . '/../../res/products');
        if ($targetDir === false) {
            throw new Exception("No se encontró la carpeta de imágenes. Ruta buscada: " . __DIR__ . '/../../res/products');
        }

        // Verificar permisos de escritura - intentar crear un archivo de prueba
        $testFile = $targetDir . DIRECTORY_SEPARATOR . '.test_write_' . time();
        $canWrite = false;
        if (is_writable($targetDir)) {
            // Intentar escribir un archivo de prueba
            $testHandle = @fopen($testFile, 'w');
            if ($testHandle !== false) {
                fclose($testHandle);
                @unlink($testFile);
                $canWrite = true;
            }
        }
        
        if (!$canWrite) {
            $perms = substr(sprintf('%o', fileperms($targetDir)), -4);
            throw new Exception("La carpeta de imágenes no tiene permisos de escritura. Permisos actuales: $perms. Ruta: $targetDir. Verifica los permisos de la carpeta res/products.");
        }

        $finalBase = $safeBase;
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $finalBase . '.' . $ext;
        $i = 1;
        while (file_exists($targetPath)) {
            $finalBase = $safeBase . '_' . $i;
            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $finalBase . '.' . $ext;
            $i++;
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            throw new Exception("No se pudo guardar la imagen en el servidor.");
        }
        
        // Guardar nombre completo con extensión en DB
        $imageBase = $finalBase . '.' . $ext;
    }

    $product->editProduct(
    $id,
    $postData['name'],
    $postData['price'],
    $postData['available_date'],
    $postData['product_description'],
    $imageBase,
    $postData['image_description'],
    $postData['product_measurements']);

    // Actualizar categorías: eliminar todas y agregar las seleccionadas
    $product->delete_product_x_category($id);
    if (!empty($postData['categories']) && is_array($postData['categories'])) {
        foreach ($postData['categories'] as $categoryId) {
            $product->add_product_x_category($id, (int)$categoryId);
        }
    }

    // Actualizar colores: eliminar todos y agregar los seleccionados
    $product->delete_product_x_color($id);
    if (!empty($postData['colors']) && is_array($postData['colors'])) {
        foreach ($postData['colors'] as $colorId) {
            $product->add_product_x_color($id, (int)$colorId);
        }
    }
    
    header('Location: ../index.php?a=product_crud');

} catch (\Exception $e) {
    $_SESSION['error_title'] = "Error al editar el producto";
    $_SESSION['error_message'] = $e->getMessage();
    $_SESSION['error_back'] = "index.php?a=product_crud";

    header("Location: ../index.php?a=generic_error");
    exit;
}