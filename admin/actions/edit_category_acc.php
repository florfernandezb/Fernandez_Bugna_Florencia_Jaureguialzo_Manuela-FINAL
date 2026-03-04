<?PHP
require_once "../../functions/autoload.php";
require_once "../../functions/auth_helpers.php";

require_admin_and_redirect();

$postData = $_POST;
$id = $_GET['id'] ?? null;

try {

    $category = new Categories();

    $category->editCategory(
        $id,
        $postData['name']
    );
    
    header('Location: ../index.php?a=category_crud');

} catch (\Exception $e) {
    $_SESSION['error_title'] = "Error al editar la categoría";
    $_SESSION['error_message'] = $e->getMessage();
    $_SESSION['error_back'] = "index.php?a=category_crud";

    header("Location: ../index.php?a=generic_error");
    exit;
}