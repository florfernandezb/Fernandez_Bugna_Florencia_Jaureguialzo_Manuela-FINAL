<?PHP
require_once "../../functions/autoload.php";
require_once "../../functions/auth_helpers.php";
require_once "../functions/upload_img.php";

require_admin_and_redirect();

$postData = $_POST;
$id = $_GET['id'] ?? null;

try {

    $product = new Products();

    $imageBase = $postData['current_image'] ?? '';

    $newImage = processProductImage($_FILES['image']);

    if ($newImage !== null) {
        $imageBase = $newImage;
    }

    $product->editProduct(
        $id,
        $postData['name'],
        $postData['price'],
        $postData['available_date'],
        $postData['product_description'],
        $imageBase,
        $postData['image_description'],
        $postData['product_measurements']
    );

    header('Location: ../index.php?a=product_crud');

} catch (\Exception $e) {

    $_SESSION['error_title'] = "Error al editar el producto";
    $_SESSION['error_message'] = $e->getMessage();
    $_SESSION['error_back'] = "index.php?a=product_crud";

    header("Location: ../index.php?a=generic_error");
    exit;
}