<?PHP
$id = $_GET['id'] ?? FALSE;
$category = (new Categories())->get_by_id($id);
?>
<div class="row my-5 g-3">
<h2 class="text-center mb-5 fw-bold">¿Está seguro que desea eliminar esta categoría?</h2>

	<div class="col-12 col-md-6">
		

			<h2>Id:</h2>
			<p><?= $category->getId() ?></p>

			<h2>Nombre de la categoría:</h2>
			<p><?= $category->getName() ?></p>
			

			<a href="actions/delete_category_acc.php?id=<?= $category->getId() ?>" role="button" class="d-block btn btn-sm btnFinalizar mt-4">Eliminar</a>
	</div>

	

</div>