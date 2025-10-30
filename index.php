        <?php
        session_start();
        $rolID=0;
        require_once 'config/config.php';
        if (isset($_SESSION["rolID"])){
                $rolID = $_SESSION["rolID"];
        }
        if ($rolID==0) {
                $_GET["controller"]="usuario";
                $_GET["action"]="login";
                $controllers = [];
        }
        if (!isset($_GET["controller"])) $_GET["controller"] = constant("DEFAULT_CONTROLLER");
        if (!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

        $controller_path = 'controller/' . $_GET["controller"] . '.php';

        /* Check if controller exists */
        if (!file_exists($controller_path)) $controller_path = 'controller/' . constant("DEFAULT_CONTROLLER") . '.php';

        /* Load controller */
        require_once $controller_path;
        $controllerName = $_GET["controller"] . 'Controller';
        $controller = new $controllerName();

        /* Check if method is defined */
        $error="";
        $dataToView["data"] = array();
        $dataToView["dataRel1"] = array();
        if (method_exists($controller, $_GET["action"])) {
                $dataToView["data"] = $controller->{$_GET["action"]}();
                $campos = $controller->getCampos();
                if ($_GET["controller"] == "venta" || $_GET["controller"] == "venta_detalle" || $_GET["controller"] == "usuario") {
                        if ($_GET["action"]!=="list") {
                                $dataToView["dataRel1"] = $controller->getTablaRel1();
                        }
                }
        }


        /* Load views */
        require_once 'view/template/header.php';
        require_once 'view/' . $controller->view . '.php';
        require_once 'view/template/footer.php';
        ?>