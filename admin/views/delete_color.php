<?PHP
$id = $_GET['id'] ?? FALSE;
$color = (new Colors())->getColorById($id);
?>
<div class="row my-5 g-3">
<h2 class="text-center mb-5 fw-bold">¿Está seguro que desea eliminar esta categoría?</h2>

	<div class="col-12 col-md-6">
		

			<h2>Id:</h2>
			<p><?= $color->getId() ?></p>

			<h3>Nombre del color:</h3>
			<p><?= $color->getColor() ?></p>
			

			<a href="actions/delete_color_acc.php?id=<?= $color->getId() ?>" role="button" class="d-block btn btn-sm btnFinalizar mt-4">Eliminar</a>
	</div>

	

</div>