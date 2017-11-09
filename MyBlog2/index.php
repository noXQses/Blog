<?php
session_start();

isset($_SESSION['logged']) ? $_SESSION['logged'] : false;
isset($_SESSION['admin']) ? $_SESSION['admin'] : false;
isset($_SESSION['controller']) ? $_SESSION['controller'] : "";
isset($_SESSION['action']) ? $_SESSION['action'] : "";
isset($_SESSION['blog_id']) ? $_SESSION['blog_id'] : "";
isset($_SESSION['artikel_id']) ? $_SESSION['artikel_id'] : "";

require_once ('classes/services/template_service.php');
require_once('classes/database_model.php');

if (isset($_REQUEST['controller']) && isset($_REQUEST['action'])) {
    $controller = $_REQUEST['controller'];
    $action     = $_REQUEST['action'];
} else {
    $controller = 'blog';
    $action     = 'list_action';
}

require_once('routes.php');
?>
