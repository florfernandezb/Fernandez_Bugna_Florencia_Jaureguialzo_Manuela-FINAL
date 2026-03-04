<?PHP
require_once "../functions/autoload.php";
require_once "../functions/auth_helpers.php";

require_login_and_redirect("cart");

(new Cart)->clear_items();
header('location: ../index.php?s=cart');