<?PHP

function processProductImage(array $file): ?string
{
    if (empty($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new Exception("Error al subir la imagen.");
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
        throw new Exception("La imagen debe ser PNG o JPG.");
    }

    if ($extension === 'jpeg') {
        $extension = 'jpg';
    }

    $safeBase = preg_replace('/[^a-zA-Z0-9_-]+/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
    $safeBase = trim($safeBase, '_') ?: 'producto_' . time();

    $targetDir = realpath(__DIR__ . '/../../res/products');
    if ($targetDir === false || !is_writable($targetDir)) {
        throw new Exception("La carpeta de imágenes no es válida o no tiene permisos.");
    }

    $finalName = $safeBase . '.' . $ext;
    $targetPath = $targetDir . DIRECTORY_SEPARATOR . $finalName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception("No se pudo guardar la imagen.");
    }

    return $finalName;
}