<?PHP
require_once "../functions/autoload.php";
require_once "../functions/auth_helpers.php";

require_login_and_redirect("cart");

$id = $_GET['id'] ?? null;

if($id != null){
    (new Cart())->remove_item($id);
    header('location: ../index.php?s=cart');
}
