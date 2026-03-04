<?php 
$id = $_GET['id'] ?? null;

$category = (new Categories)->getCategoriesById($id);
$categoriesSelectected = (new Categories)->get_categories_x_product($id);

$CATEGORY_KEYS = [
    ['label' => 'Nombre', 'type' => 'text', 'id' => 'name', 'value' => $category->getName()]
];
?>
<form action="actions/edit_category_acc.php?id=<?= $category->getId() ?>" method="POST">
    <div class="modal-header">						
        <h2 class="modal-title">Editá la categoría:</h2>
    </div>
    <div class="modal-body">	
        <?php foreach($CATEGORY_KEYS as $formData) { 
            ?>				
        <div class="form-group">
            <label><?= $formData['label'] ?></label>
            <input value="<?= $formData['value'] ?>" type=<?= $formData['type'] ?> class="form-control" id=<?= $formData['id'] ?> name=<?= $formData['id'] ?> >
        </div>
        <?php } ?>
    </div>
    <div class="modal-footer">
    <a href="index.php?a=category_crud" type="button" class="btn btnVaciar" data-dismiss="modal" value="Cancelar">Cancelar</a>
        <input type="submit" class="btn btnFinalizar" value="Guardar">
    </div>
</form>