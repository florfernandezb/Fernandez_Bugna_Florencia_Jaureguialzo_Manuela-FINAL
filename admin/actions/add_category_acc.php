<?PHP
require_once "../../functions/autoload.php";

require_admin_and_redirect();

$postData = $_POST;

try {

    $category = new Categories();

    $idCategory = $category->createCategory(
        $postData['name']
    );


    header('Location: ../index.php?a=category_crud');
} catch (\Exception $e) {
    echo "<pre>";
    print_r($e->getMessage());
    echo "<pre>";
    die("No se pudo crear la categoría");
}