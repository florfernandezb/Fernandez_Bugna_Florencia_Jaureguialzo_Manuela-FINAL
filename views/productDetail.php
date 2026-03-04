<?php
$productId = (int) $_GET['id'];
$product = (new Products())->getProductById($productId);

$productImage = $product->getImage();
$productCategories = (new Categories())->get_categories_x_product($productId);
$productColors = (new Colors())->get_colors_x_product($productId);

?>
<main class="container">
    <section class="product-details row">
        <picture class="img-prod col-6">
            <source srcset="<?= $product->getMobileImageUrl() ?>" media="(max-width:480px)">
            <img src="<?= $product->getImageUrl() ?>" alt="<?= htmlspecialchars($product->getImageDescription(), ENT_QUOTES, 'UTF-8') ?>">
        </picture>
            
        <div class="prod-details col-6">
            <h2><?= $product->getName();?></h2>

            <?php if (!empty($productCategories)): ?>
                <div class="mb-2">
                    <strong>Categorías: </strong>
                    <?php foreach ($productCategories as $cat): ?>
                        <span class="badge rounded-pill bg-dark me-1"><?= htmlspecialchars(ucfirst($cat->getName()), ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($productColors)): ?>
                <div class="mb-2">
                    <strong>Colores: </strong>
                    <?php foreach ($productColors as $col): ?>
                        <span class="badge rounded-pill bg-secondary me-1"><?= htmlspecialchars(ucfirst($col->getColor()), ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <p>Precio: $<?= $product->getPrice();?></p>
            <p>Descripcion: <?= $product->getProductDescription();?></p>    
            <p>Disponible a partir de: <?= $product->getDate();?></p>    
        </div>
        <form action="actions/add_to_cart.php" method="GET" class="row">
            <div class="col-6 d-flex align-items-center">
                <label for="q" class="fw-bold me-2">Cantidad: </label>
                <input type="number" class="form-control" value="1" name="q" id="q">
            </div>
            <div class="col-6">
                <input type="submit" value="COMPRAR" class="btn btnFinalizar w-100 fw-bold">
                <input type="hidden" value="<?= $productId ?>" name="id" id="id">
            </div>
        </form>
    </section>
    <div class="row">
        <a class="back col-12" href="index.php?s=productList">Volver a productos</a>
    </div>
</main>