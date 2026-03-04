<?php
/**
 * Script de diagnóstico de permisos
 * Acceder desde: http://localhost/Fernandez_Bugna_Florencia_Jaureguialzo_Manuela-FINAL/admin/test_permissions.php
 */

$targetDir = realpath(__DIR__ . '/../res/products');

echo "<h2>Diagnóstico de Permisos - Carpeta res/products</h2>";
echo "<pre>";

echo "Ruta absoluta: " . ($targetDir ?: "NO ENCONTRADA") . "\n";
echo "Ruta relativa buscada: " . __DIR__ . '/../res/products' . "\n\n";

if ($targetDir) {
    echo "Existe: SÍ\n";
    echo "Es directorio: " . (is_dir($targetDir) ? "SÍ" : "NO") . "\n";
    echo "Permisos (octal): " . substr(sprintf('%o', fileperms($targetDir)), -4) . "\n";
    echo "Permisos (texto): " . substr(sprintf('%o', fileperms($targetDir)), -4) . "\n";
    echo "is_readable(): " . (is_readable($targetDir) ? "SÍ" : "NO") . "\n";
    echo "is_writable(): " . (is_writable($targetDir) ? "SÍ" : "NO") . "\n";
    
    // Intentar escribir un archivo de prueba
    $testFile = $targetDir . DIRECTORY_SEPARATOR . '.test_write_' . time() . '.txt';
    echo "\n--- Prueba de escritura ---\n";
    $testHandle = @fopen($testFile, 'w');
    if ($testHandle !== false) {
        fwrite($testHandle, "test");
        fclose($testHandle);
        echo "✓ Escritura exitosa\n";
        echo "Archivo creado: $testFile\n";
        if (@unlink($testFile)) {
            echo "✓ Archivo eliminado correctamente\n";
        } else {
            echo "✗ No se pudo eliminar el archivo de prueba\n";
        }
    } else {
        echo "✗ No se pudo escribir en la carpeta\n";
        $error = error_get_last();
        if ($error) {
            echo "Error: " . $error['message'] . "\n";
        }
    }
} else {
    echo "✗ La carpeta NO existe\n";
}

echo "\n--- Información del servidor ---\n";
echo "Usuario PHP: " . (function_exists('get_current_user') ? get_current_user() : 'N/A') . "\n";
echo "Usuario efectivo: " . (function_exists('posix_geteuid') ? posix_getpwuid(posix_geteuid())['name'] : 'N/A') . "\n";
echo "Grupo efectivo: " . (function_exists('posix_getegid') ? posix_getgrgid(posix_getegid())['name'] : 'N/A') . "\n";

if ($targetDir && function_exists('posix_getpwuid') && function_exists('stat')) {
    $stat = stat($targetDir);
    echo "Propietario (UID): " . $stat['uid'] . "\n";
    echo "Grupo (GID): " . $stat['gid'] . "\n";
    $owner = posix_getpwuid($stat['uid']);
    $group = posix_getgrgid($stat['gid']);
    echo "Propietario (nombre): " . ($owner ? $owner['name'] : 'N/A') . "\n";
    echo "Grupo (nombre): " . ($group ? $group['name'] : 'N/A') . "\n";
}

echo "</pre>";
echo "<p><a href='index.php?a=add_product'>← Volver al formulario</a></p>";
?>
