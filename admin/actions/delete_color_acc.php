<?PHP
require_once "../../functions/autoload.php";

require_admin_and_redirect();

$id = $_GET['id'] ?? FALSE;
$color = (new Colors())->getColorById($id);

$postData = $_POST;

try {
    $color = new Colors();
    $product = new Products();

    $productsList = $product->getProductsByColor($id);
    
    foreach ($productsList as $prod) {
        $product->delete_product_x_color($prod->getProductId());
    }

    $color->deleteColor($id);

    header('Location: ../index.php?a=color_crud');
} catch (\Exception $e) {
    echo "<pre>";
    print_r($e->getMessage());
    echo "<pre>";
    die("No se pudo eliminar el color");
}