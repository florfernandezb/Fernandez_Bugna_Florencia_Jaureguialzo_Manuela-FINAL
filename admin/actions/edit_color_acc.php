<?PHP
require_once "../../functions/autoload.php";

require_admin_and_redirect();

$postData = $_POST;
$id = $_GET['id'] ?? null;

try {

    $color = new Colors();

    $color->editColor(
        $id,
        $postData['name']
    );
    
    header('Location: ../index.php?a=color_crud');

} catch (\Exception $e) {
    echo "<pre>";
    print_r($e->getMessage());
    echo "<pre>";
    die("No se pudo editar el producto ");
}