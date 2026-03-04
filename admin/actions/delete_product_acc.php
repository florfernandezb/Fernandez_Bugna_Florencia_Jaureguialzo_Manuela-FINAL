<?PHP
require_once "../../functions/autoload.php";

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
    echo "<pre>";
    print_r($e->getMessage());
    echo "<pre>";
    die("No se pudo eliminar la categoría");
}