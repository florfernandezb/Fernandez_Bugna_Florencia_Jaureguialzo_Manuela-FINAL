<?PHP
$id = $_GET['id'] ?? FALSE;
$category = (new Categories())->get_by_id($id);
?>
<div class="row my-5 justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">

        <div class="card shadow-sm border-0 p-4 text-center confirm-card">

            <h2 class="fw-bold mb-4 confirm-title">
                Confirmar eliminación
            </h2>

            <p class="mb-4">
                ¿Está segura que desea eliminar esta categoría?
                <br>
                <strong>Esta acción no se puede deshacer.</strong>
            </p>

            <div class="category-box p-3 rounded mb-4">
                <p class="mb-1"><strong>ID:</strong> <?= $category->getId() ?></p>
                <p class="mb-0">
                    <strong>Nombre:</strong>
                    <?= htmlspecialchars($category->getName(), ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>

            <div class="d-flex justify-content-center gap-3">
                <a href="actions/delete_category_acc.php?id=<?= $category->getId() ?>"
                   class="btn btn-delete px-4">
                    Sí, eliminar
                </a>

                <a href="index.php?s=list_categories"
                   class="btn btn-cancel px-4">
                    Cancelar
                </a>
            </div>

        </div>

    </div>
</div>