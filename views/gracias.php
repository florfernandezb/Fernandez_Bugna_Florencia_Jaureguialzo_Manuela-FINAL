<?php

$name = $_POST['nombre'];
$comment = $_POST['comentarios'];

?>
<main>
    <section class="gracias">
        <h2>¡Gracias  <?= $name ?> por contactarnos!</h2>
        <p>Tu mensaje <q> <?= $comment ?>!</q> ha sido enviado. Te responderemos a la brevedad.</p>
        <a href="index.php">Seguir navegando</a>
    </section>
</main>