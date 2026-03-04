<?PHP
require_once "../../functions/autoload.php";
require_once "../../functions/auth_helpers.php";

require_admin_and_redirect();

$id = $_GET['id'] ?? FALSE;
$categories = $_GET['categories'] ?? NULL;
$product = (new Products())->getProductById($id);

$postData = $_POST;

try {
    $product = new Products();

    foreach ($postData as $category) {
        $product->delete_product_x_category($id);
    }

    $product->deleteProduct($id);

    header('Location: ../index.php?a=product_crud');
} catch (\Exception $e) {
    $_SESSION['error_title'] = "Error al borrar el producto";
    $_SESSION['error_message'] = $e->getMessage();
    $_SESSION['error_back'] = "index.php?a=add_product";

    header("Location: ../index.php?a=generic_error");
    exit;
}