<?php

$products = new Products();
$productList = $products->getProducts();

$selectedCategory = isset($_GET['category']) && $_GET['category'] !== '' ? (int)$_GET['category'] : null;
$selectedColor = isset($_GET['color']) && $_GET['color'] !== '' ? (int)$_GET['color'] : null;

if ($selectedCategory !== null || $selectedColor !== null) {
    $productList = $products->getProductsFiltered($selectedCategory, $selectedColor);
}

?>
<main>
    <section id="product-list">
        <h2>Conocé nuestros productos</h2>

        <form method="GET" action="index.php" class="row g-3 align-items-end my-3">
            <input type="hidden" name="s" value="productList">

            <div class="col-12 col-md-6">
                <label for="category" class="form-label fw-bold">Categoría</label>
                <select class="form-select" name="category" id="category">
                    <option value="">Todas</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= (int)$category->getId() ?>" <?= ($selectedCategory !== null && (int)$category->getId() === $selectedCategory) ? 'selected' : '' ?>>
                            <?= htmlspecialchars(ucfirst($category->getName()), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12 col-md-4">
                <label for="color" class="form-label fw-bold">Color</label>
                <select class="form-select" name="color" id="color">
                    <option value="">Todos</option>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?= (int)$color->getId() ?>" <?= ($selectedColor !== null && (int)$color->getId() === $selectedColor) ? 'selected' : '' ?>>
                            <?= htmlspecialchars(ucfirst($color->getColor()), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12 col-md-2 d-grid">
                <button type="submit" class="btn btnFinalizar fw-bold">Filtrar</button>
            </div>
        </form>

        <div class="row ">
            <?php
                foreach($productList as $product):
                $productImage = $product->getImage();
                ?>
            
            <article class=" col-xxl-4 col-md-6 col-xs-6">
                <div class="product-card">
                    <picture>
                        <source srcset="<?= $product->getMobileImageUrl() ?>" media="(max-width:480px)">
                        <img src="<?= $product->getImageUrl() ?>" alt="<?= htmlspecialchars($product->getImageDescription(), ENT_QUOTES, 'UTF-8') ?>">
                    </picture>
                    <div class="card-content">
                        <h3><?= $product->getName();?></h3>
                        <p>$<?= $product->getPrice();?></p>
                        <p>Medidas: <?= $product->getMeasurements();?></p>
                    </div>
                    
                    <a href="index.php?s=productDetail&id=<?= $product->getProductId();?>" class="see-more">Ver más</a>
                </div>
            </article>
            <?php
            endforeach; ?>
        </div>
    </section>
</main>
