<?php
    $TABLE_COLUMNS = [
        'Id', 
        'Nombre', 
        'Precio', 
        'Disponibilidad', 
        'Descripción', 
        'Categorías',
        'Colores',
        'Imagen', 
        'Descripción de la imagen', 
        'Medidas', 
        'Acciones'
    ];
    $products = new Products();
    $productList = $products->getProducts();
    $categoriesObj = new Categories();
    $colorsObj = new Colors();
    
?>
<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h2>Gestión de <b>Productos</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="index.php?a=add_product" class="btn btnFinalizar" data-toggle="modal"><i class="bi bi-plus-circle-fill biIconsLight"></i> <span>Agregar nuevo producto</span></a>
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
                <?PHP foreach ($productList as $product) { ?>
                    <tr>                   
						<td><p>  <?=  $product->getProductId() ?> </p></td>
						<td> <?=  $product->getName() ?> </td>
						<td> <?=  $product->getPrice() ?> </td>
						<td> <?=  $product->getDate() ?> </td>
                        <td> <?=  $product->getProductDescription() ?> </td>
						<td>
							<?php
								$cats = $categoriesObj->get_categories_x_product((int)$product->getProductId());
								if (!empty($cats)) {
									foreach ($cats as $cat) {
										echo '<span class="badge rounded-pill bg-dark me-1">' . htmlspecialchars(ucfirst($cat->getName()), ENT_QUOTES, 'UTF-8') . '</span>';
									}
								} else {
									echo '<span class="text-muted">-</span>';
								}
							?>
						</td>
						<td>
							<?php
								$cols = $colorsObj->get_colors_x_product((int)$product->getProductId());
								if (!empty($cols)) {
									foreach ($cols as $col) {
										echo '<span class="badge rounded-pill bg-secondary me-1">' . htmlspecialchars(ucfirst($col->getColor()), ENT_QUOTES, 'UTF-8') . '</span>';
									}
								} else {
									echo '<span class="text-muted">-</span>';
								}
							?>
						</td>
						<td> <img src="<?= $product->getImageUrl('../res/products/') ?>" alt="Imagen Ilustrativa de <?= htmlspecialchars($product->getImageDescription(), ENT_QUOTES, 'UTF-8') ?>" class="img-fluid rounded"> </td>
                        <td> <?=  $product->getImageDescription() ?> </td>
                        <td> <?=  $product->getMeasurements() ?> </td>
						<td>
							<a href="index.php?a=modify_product&id=<?= $product->getProductId() ?>" class="edit" data-toggle="modal"><i class="bi bi-pen-fill biIcons"></i></a>
							<a href="index.php?a=delete_product&id=<?= $product->getProductId() ?>" class="delete" data-toggle="modal"><i class="bi bi-trash-fill" data-toggle="tooltip" title="" data-original-title="Delete"></i></a>
						</td>
					</tr>
                <?PHP } ?>
				</tbody>
			</table>
		</div>
	</div>        
</div>