<?php 
$id = $_GET['id'] ?? null;

$color = (new Colors)->getColorById($id);

$COLOR_KEYS = [
    ['label' => 'Nombre', 'type' => 'text', 'id' => 'name', 'value' => $color->getColor()]
];
?>
<form action="actions/edit_color_acc.php?id=<?= $color->getId() ?>" method="POST">
    <div class="modal-header">						
        <h2 class="modal-title">Editá el color:</h2>
    </div>
    <div class="modal-body">	
        <?php foreach($COLOR_KEYS as $formData) { 
            ?>				
        <div class="form-group">
            <label><?= $formData['label'] ?></label>
            <input value="<?= $formData['value'] ?>" type=<?= $formData['type'] ?> class="form-control" id=<?= $formData['id'] ?> name=<?= $formData['id'] ?> >
        </div>
        <?php } ?>
    </div>
    <div class="modal-footer">
    <a href="index.php?a=color_crud" type="button" class="btn btnVaciar" data-dismiss="modal" value="Cancelar">Cancelar</a>
        <input type="submit" class="btn btnFinalizar" value="Guardar">
    </div>
</form>