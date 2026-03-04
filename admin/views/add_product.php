<?php 
$categories = (new Categories)->getCategories();
$colors = (new Colors)->getColors();

$PRODUCT_KEYS = [
    ['label' => 'Nombre', 'type' => 'text', 'id' => 'name'],
    ['label' => 'Precio', 'type' => 'number', 'id' => 'price'], 
    ['label' => 'Disponibilidad', 'type' => 'date', 'id' => 'available_date'], 
    ['label' => 'Descripción', 'type' => 'text', 'id' => 'product_description'], 
    ['label' => 'Imagen', 'type' => 'file', 'id' => 'image'], 
    ['label' => 'Descripción de la imagen', 'type' => 'text', 'id' => 'image_description'],
    ['label' => 'Medidas del producto', 'type' => 'text', 'id' => 'product_measurements'], 
];
?>
<form action="actions/add_product_acc.php" method="POST" enctype="multipart/form-data">
    <div class="modal-header">						
        <h2 class="modal-title">Agregá un producto:</h2>
    </div>
    <div class="modal-body">	
        <?php foreach($PRODUCT_KEYS as $formData) { 
            ?>				
        <div class="form-group">
            <label><?= $formData['label'] ?><?= $formData['id'] === 'image' ? ' (PNG o JPG)' : '' ?></label>
            <input type=<?= $formData['type'] ?> class="form-control" id=<?= $formData['id'] ?> name=<?= $formData['id'] ?> <?= $formData['id'] === 'image' ? 'accept="image/png,image/jpeg,image/jpg"' : '' ?> required>
        </div>
        <?php } ?>
        <div class="form-group">
        <label>Categoría</label>
        <select class="form-select" name="category" id="category" required>
            <?php foreach($categories as $category) { ?>
            <option value=<?= $category->getId() ?>> <?= $category->getName() ?> </option>
            <?php } ?>
        </select>
        </div>

        <div class="form-group">
            <label>Colores</label>
            <?php foreach($colors as $color) { ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="<?= $color->getId() ?>" id="color_<?= $color->getId() ?>" name="colors[]">
                    <label class="form-check-label" for="color_<?= $color->getId() ?>"> <?= htmlspecialchars(ucfirst($color->getColor()), ENT_QUOTES, 'UTF-8') ?> </label>
                </div>
            <?php } ?>
        </div>
        
    </div>
    <div class="modal-footer">
        <a href="index.php?a=product_crud" type="button" class="btn btnVaciar" data-dismiss="modal" value="Cancelar">Cancelar</a>
        <input type="submit" class="btn btnFinalizar" value="Guardar">
    </div>
</form>