<?PHP
require_once "../../functions/autoload.php";

require_admin_and_redirect();

$id = $_GET['id'] ?? FALSE;
$category = (new Categories())->get_by_id($id);

$postData = $_POST;

try {
    $category = new Categories();
    $product = new Products();

    $productsList = $product->getProductsByCategory($id);
    
    foreach ($productsList as $prod) {
        $product->delete_product_x_category($prod->getProductId());
    }

    $category->deleteCategory($id);

    header('Location: ../index.php?a=category_crud');
} catch (\Exception $e) {
    echo "<pre>";
    print_r($e->getMessage());
    echo "<pre>";
    die("No se pudo eliminar la categoría");
}