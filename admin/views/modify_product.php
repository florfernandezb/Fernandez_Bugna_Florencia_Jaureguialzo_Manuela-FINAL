<?php 
$categories = (new Categories)->getCategories();
$colors = (new Colors)->getColors();
$id = $_GET['id'] ?? null;

$product = (new Products)->getProductById($id);
$categoriesSelectected = (new Categories)->get_categories_x_product($id);
$colorsSelected = (new Colors)->get_colors_x_product($id);

$PRODUCT_KEYS = [
    ['label' => 'Nombre', 'type' => 'text', 'id' => 'name', 'value' => $product->getName()],
    ['label' => 'Precio', 'type' => 'number', 'id' => 'price', 'value' => $product->getPrice()], 
    ['label' => 'Disponibilidad', 'type' => 'date', 'id' => 'available_date', 'value' => $product->getDate()], 
    ['label' => 'Descripcion', 'type' => 'text', 'id' => 'product_description', 'value' => $product->getProductDescription()], 
    ['label' => 'Descripcion de la imagen', 'type' => 'text', 'id' => 'image_description', 'value' => $product->getImageDescription()],
    ['label' => 'Medidas del producto', 'type' => 'text', 'id' => 'product_measurements', 'value' => $product->getMeasurements()], 
];
?>
<form action="actions/edit_product_acc.php?id=<?= $product->getProductId() ?>" method="POST" enctype="multipart/form-data">
    <div class="modal-header">						
        <h2 class="modal-title">Editá tu producto:</h2>
    </div>
    <div class="modal-body">	
        <?php foreach($PRODUCT_KEYS as $formData) { 
            ?>				
        <div class="form-group">
            <label><?= $formData['label'] ?></label>
            <input value="<?= $formData['value'] ?>" type=<?= $formData['type'] ?> class="form-control" id=<?= $formData['id'] ?> name=<?= $formData['id'] ?> >
        </div>
        <?php } ?>

        <div class="form-group my-3">
            <label class="fw-bold d-block">Imagen actual</label>
            <div class="mb-2">
                <img src="<?= $product->getImageUrl('../res/products/') ?>" alt="Imagen actual de <?= htmlspecialchars($product->getName(), ENT_QUOTES, 'UTF-8') ?>" class="img-fluid rounded" style="max-width: 220px;">
            </div>
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($product->getImage(), ENT_QUOTES, 'UTF-8') ?>">
            <label for="image" class="form-label">Reemplazar imagen (PNG o JPG)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/png,image/jpeg,image/jpg">
        </div>
        <div class="form-group">
			<label>Categorías</label>
			<?php foreach($categories as $category) { ?>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="<?= $category->getId() ?>" id="category_<?= $category->getId() ?>" name="categories[]" 
						<?php foreach($categoriesSelectected as $cat) { ?> 
							<?= $cat->getId() ==  $category->getId() ? "checked" : "" ?>
						<?php }  ?>
					>
					<label class="form-check-label" for="category_<?= $category->getId() ?>"> <?= htmlspecialchars(ucfirst($category->getName()), ENT_QUOTES, 'UTF-8') ?> </label>
				</div>
       		<?php }  ?>
        </div>

        <div class="form-group">
			<label>Colores</label>
			<?php foreach($colors as $color) { ?>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="<?= $color->getId() ?>" id="color_<?= $color->getId() ?>" name="colors[]" 
						<?php foreach($colorsSelected as $col) { ?> 
							<?= $col->getId() ==  $color->getId() ? "checked" : "" ?>
						<?php }  ?>
					>
					<label class="form-check-label" for="color_<?= $color->getId() ?>"> <?= htmlspecialchars(ucfirst($color->getColor()), ENT_QUOTES, 'UTF-8') ?> </label>
				</div>
       		<?php }  ?>
        </div>
		
    </div>
    <div class="modal-footer">
        <a href="index.php?a=product_crud" type="button" class="btn btnVaciar" data-dismiss="modal" value="Cancelar">Cancelar</a>
        <input type="submit" class="btn btnFinalizar" value="Guardar">
    </div>
</form>