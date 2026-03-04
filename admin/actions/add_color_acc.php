<?PHP
require_once "../../functions/autoload.php";
require_once "../../functions/auth_helpers.php";

require_admin_and_redirect();

$postData = $_POST;

try {

    $color = new Colors();

    $idColor = $color->createColor(
        $postData['color']
    );


    header('Location: ../index.php?a=color_crud');
} catch (\Exception $e) {
    $_SESSION['error_title'] = "Error al crear el color";
    $_SESSION['error_message'] = $e->getMessage();
    $_SESSION['error_back'] = "index.php?a=add_color";

    header("Location: ../index.php?a=generic_error");
    exit;
}