<?php
function call($controller , $action)
{
    require_once('controller/' . $controller . '_controller.php');

    switch($controller)
    {
        case 'blog':
            $controller = new BlogController();
            break;
        case 'artikel':
            $controller = new ArtikelController();
            break;
        case 'artikel_details':
            $controller = new ArtikelDetailsController();
            break;
        case 'general':
            $controller = new GeneralController();
            break;
        case 'user':
            $controller = new UserController();
            break;
    }

    $controller->{ $action }();
}

$controllers = array('blog' => ['list_action', 'blog_neu', 'blog_loeschen', 'error'], 'artikel' => ['list_action', 'artikel_neu', 'artikel_loeschen', 'error'], 'artikel_details' => ['list_action'], 'general' => ['impressum', 'kontakt'], 'user' => ['logout', 'login', 'anmelden']);

if (array_key_exists($controller, $controllers))
{
    if (in_array($action, $controllers[$controller]))
    {
        call($controller, $action);
    }
    else
    {
        call('general', 'error');
    }
}
else
{
    call('general', 'error');
}

?>
