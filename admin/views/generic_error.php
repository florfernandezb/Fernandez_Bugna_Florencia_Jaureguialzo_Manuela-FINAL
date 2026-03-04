<?php
$errorMessage = $_SESSION['error_message'] ?? "Ocurrió un error inesperado.";
$errorTitle   = $_SESSION['error_title'] ?? "Error";
$errorBack    = $_SESSION['error_back'] ?? "index.php";

unset($_SESSION['error_message']);
unset($_SESSION['error_title']);
unset($_SESSION['error_back']);
?>

<div class="error-container">
    <h3><?= htmlspecialchars($errorTitle, ENT_QUOTES, 'UTF-8') ?></h3>

    <p>
        <strong>Mensaje:</strong>
        <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
    </p>

    <a href="<?= htmlspecialchars($errorBack, ENT_QUOTES, 'UTF-8') ?>">
        ← Volver
    </a>
</div>