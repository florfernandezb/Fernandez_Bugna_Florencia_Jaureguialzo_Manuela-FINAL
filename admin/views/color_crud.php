<?php
    $TABLE_COLUMNS = [
        'Id', 
        'Color',  
        'Acciones'
    ];
    $colors = new Colors();
    $colorList = $colors->getColors();
    
?>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Gestión de <b>Colores:</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="index.php?a=add_color" class="btn btnFinalizar" data-toggle="modal"><i class="bi bi-plus-circle-fill biIconsLight"></i> <span>Agregar un nuevo color</span></a>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
                        <?PHP foreach ($TABLE_COLUMNS as $color) { ?>
						<th><?= $color ?></th>
                        <?PHP } ?>
					</tr>
				</thead>
				<tbody>
                <?PHP foreach ($colorList as $color) { ?>
                    <tr>                   
						<td><p>  <?=  $color->getId() ?> </p></td>
						<td> <?=  $color->getColor() ?> </td>
						<td>
							<a href="index.php?a=modify_color&id=<?= $color->getId() ?>" class="edit" data-toggle="modal"><i class="bi bi-pen-fill biIcons"></i></a>
							<a href="index.php?a=delete_color&id=<?= $color->getId() ?>" class="delete" data-toggle="modal"><i class="bi bi-trash-fill" data-toggle="tooltip" title="" data-original-title="Delete"></i></a>
						</td>
					</tr>
                <?PHP } ?>
				</tbody>
			</table>
		</div>
	</div>        
</div>