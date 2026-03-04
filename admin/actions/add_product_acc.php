<?PHP
require_once "../../functions/autoload.php";

require_admin_and_redirect();

$postData = $_POST;

try {

    $product = new Products();

    $imageBase = null;
    if (!empty($_FILES['image']) && is_array($_FILES['image']) && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
        $uploadError = $_FILES['image']['error'] ?? UPLOAD_ERR_OK;
        if ($uploadError !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => "El archivo excede el tamaño máximo permitido por PHP (upload_max_filesize).",
                UPLOAD_ERR_FORM_SIZE => "El archivo excede el tamaño máximo permitido por el formulario.",
                UPLOAD_ERR_PARTIAL => "El archivo se subió parcialmente.",
                UPLOAD_ERR_NO_FILE => "No se seleccionó ningún archivo.",
                UPLOAD_ERR_NO_TMP_DIR => "Falta la carpeta temporal.",
                UPLOAD_ERR_CANT_WRITE => "Error al escribir el archivo en disco.",
                UPLOAD_ERR_EXTENSION => "Una extensión de PHP detuvo la subida del archivo.",
            ];
            $errorMsg = $errorMessages[$uploadError] ?? "Error desconocido al subir la imagen (código: $uploadError).";
            throw new Exception($errorMsg);
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
        
        // Guardar nombre completo con extensión en DB
        $imageBase = $finalBase . '.' . $ext;

        // Verificar que el archivo temporal existe y es válido
        if (!isset($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])) {
            throw new Exception("El archivo temporal no es válido o no se subió correctamente.");
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $errorMsg = "No se pudo guardar la imagen en el servidor.";
            $errorMsg .= " Ruta destino: " . $targetPath;
            $errorMsg .= " Archivo temporal: " . ($_FILES['image']['tmp_name'] ?? 'no disponible');
            $errorMsg .= " Error PHP: " . ($_FILES['image']['error'] ?? 'desconocido');
            if (function_exists('error_get_last')) {
                $lastError = error_get_last();
                if ($lastError) {
                    $errorMsg .= " Último error: " . $lastError['message'];
                }
            }
            throw new Exception($errorMsg);
        }
    } else {
        // fallback si por algún motivo no viene archivo (igual el input está required en la vista)
        $imageBase = $postData['image'] ?? '';
    }

    $idproduct = $product->createProduct(
        $postData['name'],
        $postData['price'],
        $postData['available_date'],
        $postData['product_description'],
        $imageBase,
        $postData['image_description'],
        $postData['product_measurements']
    );

    if (isset($postData['category']) && $idproduct != null) {
        $product->add_product_x_category($idproduct, $postData['category']);
    }

    // Agregar colores seleccionados
    if (!empty($postData['colors']) && is_array($postData['colors']) && $idproduct != null) {
        foreach ($postData['colors'] as $colorId) {
            $product->add_product_x_color($idproduct, (int)$colorId);
        }
    }

    header('Location: ../index.php?a=product_crud');
} catch (\Exception $e) {
    echo "<div style='padding: 20px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px;'>";
    echo "<h3 style='color: #721c24; margin-top: 0;'>Error al crear el producto</h3>";
    echo "<p style='color: #721c24;'><strong>Mensaje:</strong> " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
    echo "<p><a href='../index.php?a=add_product' style='color: #721c24; text-decoration: underline;'>← Volver al formulario</a></p>";
    echo "</div>";
    die();
}