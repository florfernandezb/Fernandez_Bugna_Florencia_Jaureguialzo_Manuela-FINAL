<?PHP
require_once "../../functions/autoload.php";
require_once "../functions/upload_img.php";
require_once "../../functions/auth_helpers.php";

require_admin_and_redirect();

$postData = $_POST;

try {

    $product = new Products();

    $productImg = processProductImage($_FILES['image']);

    $idproduct = $product->createProduct(
        $postData['name'],
        $postData['price'],
        $postData['available_date'],
        $postData['product_description'],
        $productImg,
        $postData['image_description'],
        $postData['product_measurements']
    );

    if (isset($postData['category']) && $idproduct != null) {
        $product->add_product_x_category($idproduct, $postData['category']);
    }

    if (!empty($postData['colors']) && is_array($postData['colors']) && $idproduct != null) {
        foreach ($postData['colors'] as $colorId) {
            $product->add_product_x_color($idproduct, (int)$colorId);
        }
    }

    header('Location: ../index.php?a=product_crud');
} catch (\Exception $e) {
    $_SESSION['error_title'] = "Error al crear el producto";
    $_SESSION['error_message'] = $e->getMessage();
    $_SESSION['error_back'] = "index.php?a=add_product";

    header("Location: ../index.php?a=generic_error");
    exit;
}