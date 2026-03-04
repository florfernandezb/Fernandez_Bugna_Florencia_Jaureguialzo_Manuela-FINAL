<?php

function processProductImage(array $file): ?string
{
    if (empty($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Error al subir la imagen.");
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
        throw new Exception("La imagen debe ser PNG o JPG.");
    }

    if ($extension === 'jpeg') {
        $extension = 'jpg';
    }

    $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
    $safeName = $safeName ?: 'producto_' . time();

    $targetDir = __DIR__ . '/../../res/products/';
    $finalName = $safeName . '.' . $extension;

    $targetPath = $targetDir . $finalName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception("No se pudo guardar la imagen.");
    }

    return $finalName;
}