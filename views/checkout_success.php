<?php
$order = $_SESSION['last_order'] ?? null;
?>
<main class="container my-5">
    <section class="text-center">
        <h2 class="mb-4">¡Compra finalizada!</h2>

        <?php if (!$order || empty($order['items'])): ?>
            <p class="text-muted">No encontramos un resumen de compra. Si necesitás ayuda, escribinos desde Contacto.</p>
        <?php else: ?>
            <p class="mb-4">Gracias por tu compra. Te dejamos el resumen:</p>

            <div class="table-responsive">
                <table class="table text-center align-middle">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                            <tr>
                                <td class="text-start">
                                    <?= htmlspecialchars($item['product'], ENT_QUOTES, 'UTF-8') ?>
                                </td>
                                <td><?= (int)$item['cantidad'] ?></td>
                                <td>$<?= number_format((float)$item['precio'], 2, ",", ".") ?></td>
                                <td>$<?= number_format((float)$item['precio'] * (int)$item['cantidad'], 2, ",", ".") ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="fw-bold">$<?= number_format((float)$order['total'], 2, ",", ".") ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="index.php?s=productList" class="btn btnFinalizar mt-3">Volver a productos</a>
    </section>
</main>

<?php unset($_SESSION['last_order']); ?>

