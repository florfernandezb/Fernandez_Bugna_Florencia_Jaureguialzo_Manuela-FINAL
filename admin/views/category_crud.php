<?php
    $TABLE_COLUMNS = [
        'Id', 
        'Nombre de categoría',  
        'Acciones'
    ];
    $categories = new Categories();
    $categoryList = $categories->getCategories();
    
?>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Gestión de <b>Categorías</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="index.php?a=add_category" class="btn btnFinalizar" data-toggle="modal"><i class="bi bi-plus-circle-fill biIconsLight"></i> <span>Agregar nueva categoría</span></a>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
                        <?PHP foreach ($TABLE_COLUMNS as $name) { ?>
						<th><?= $name ?></th>
                        <?PHP } ?>
					</tr>
				</thead>
				<tbody>
                <?PHP foreach ($categoryList as $category) { ?>
                    <tr>                   
						<td><p>  <?=  $category->getId() ?> </p></td>
						<td> <?=  $category->getName() ?> </td>
						<td>
							<a href="index.php?a=modify_category&id=<?= $category->getId() ?>" class="edit" data-toggle="modal"><i class="bi bi-pen-fill biIcons"></i></a>
							<a href="index.php?a=delete_category&id=<?= $category->getId() ?>" class="delete" data-toggle="modal"><i class="bi bi-trash-fill" data-toggle="tooltip" title="" data-original-title="Delete"></i></a>
						</td>
					</tr>
                <?PHP } ?>
				</tbody>
			</table>
		</div>
	</div>        
</div>