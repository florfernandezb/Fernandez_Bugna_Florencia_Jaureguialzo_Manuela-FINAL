<?PHP
require_once "../functions/autoload.php";

require_login_and_redirect("productDetail&id=" . urlencode((string)($_GET['id'] ?? '')));

$id = $_GET['id'] ?? null;
$q = $_GET['q'] ?? 1;

if($id != null){
    (new Cart)->add_item((int)$id, (int)$q);
    header('location: ../index.php?s=productList');
} else {
    echo"else";
}
