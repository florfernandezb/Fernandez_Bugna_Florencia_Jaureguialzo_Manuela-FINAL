<?php 
$categories = (new Categories)->getCategories();
$id = $_GET['id'] ?? null;

$product = (new Products)->getProductById($id);
$categoriesSelectected = (new Categories)->get_categories_x_product($id);

$PRODUCT_KEYS = [
    ['label' => 'Nombre', 'type' => 'text', 'id' => 'name', 'value' => $product->getName()],
    ['label' => 'Precio', 'type' => 'number', 'id' => 'price', 'value' => $product->getPrice()], 
    ['label' => 'Disponibilidad', 'type' => 'date', 'id' => 'available_date', 'value' => $product->getDate()], 
    ['label' => 'Descripcion', 'type' => 'text', 'id' => 'product_description', 'value' => $product->getProductDescription()], 
    ['label' => 'Imagen', 'type' => 'text', 'id' => 'image', 'value' => $product->getImage()], 
    ['label' => 'Descripcion de la imagen', 'type' => 'text', 'id' => 'image_description', 'value' => $product->getImageDescription()],
    ['label' => 'Medidas del producto', 'type' => 'text', 'id' => 'product_measurements', 'value' => $product->getMeasurements()], 
];
?>
<form action="actions/delete_product_acc.php?id=<?= $product->getProductId() ?>" method="POST">
    <div class="modal-header">						
        <h2 class="modal-title">Eliminá tu producto</h2>
    </div>
    <div class="modal-body">	
        <?php foreach($PRODUCT_KEYS as $formData) { 
            ?>				
        <div class="form-group">
            <label><?= $formData['label'] ?></label>
            <input value="<?= $formData['value'] ?>" type=<?= $formData['type'] ?> class="form-control" id=<?= $formData['id'] ?> name=<?= $formData['id'] ?> disabled >
        </div>
        <?php } ?>
        <div class="form-group">
			<label>Categorías</label>
			<?php foreach($categories as $category) { ?>
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value="<?= $category->getId() ?>" disabled id="categories" name="categories" 
						<?php foreach($categoriesSelectected as $cat) { ?> 
							<?= $cat->getId() ==  $category->getId() ? "checked" : "" ?>
						<?php }  ?>
					>
					<label class="form-check-label" for="<?= $category->getId() ?>"> <?= $category->getName() ?> </label>
				</div>
       		<?php }  ?>
            <?php foreach($categoriesSelectected as $key=>$category) { ?>
                <div class="col-6">
                    <input type="text" value="<?= $category->getId() ?>" name="<?= $key ?>" class="btn btn-danger w-100 fw-bold" hidden>
                </div>
            <?php }  ?>
        </div>
		
    </div>
    <div class="modal-footer">
        <a href="index.php?a=product_crud" type="button" class="btn btnVaciar" data-dismiss="modal" value="Cancelar">Cancelar</a>
        <input type="submit" class="btn btnFinalizar" value="Eliminar">
    </div>
</form>