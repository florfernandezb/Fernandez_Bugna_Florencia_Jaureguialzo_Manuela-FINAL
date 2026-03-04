<?PHP
require_once "../../functions/autoload.php";


(new Authentication())->log_out();
header('location: ../../index.php?s=login');