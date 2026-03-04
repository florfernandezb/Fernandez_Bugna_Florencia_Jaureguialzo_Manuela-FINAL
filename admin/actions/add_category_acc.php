<?PHP
require_once "../../functions/autoload.php";
require_once "../../functions/auth_helpers.php";

require_admin_and_redirect();

$postData = $_POST;

try {

    $category = new Categories();

    $idCategory = $category->createCategory(
        $postData['name']
    );


    header('Location: ../index.php?a=category_crud');
} catch (\Exception $e) {
    $_SESSION['error_title'] = "Error al crear la categoría";
    $_SESSION['error_message'] = $e->getMessage();
    $_SESSION['error_back'] = "index.php?a=add_category";

    header("Location: ../index.php?a=generic_error");
    exit;
}