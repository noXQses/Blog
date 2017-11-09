<?php
require_once('classes/services/user_service.php');

class UserController
{
    public function anmelden()
    {
        $userS = new UserService();
        $userS->check_new_user_input();

        $page = new Template('views/anmelden_view.html');

        if ((isset($_SESSION['admin']) ? $_SESSION['admin'] : false) === true)
        {
            $admin_page = new Template('views/anmelden_admin_view.html');
            $page->set('admin', $admin_page->output());
        }
        else
        {
            $page->set('admin', "false");
        }

        $teSe = new TemplateService();
        $teSe->Together($page);
    }

    public function login()
    {
        $userS = new UserService();
        if($userS->check_login())
        {
            header("Location: http://localhost:8080/MyBlog2/index.php?controller=blog&action=list_action");
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: http://localhost:8080/MyBlog2/index.php?controller=blog&action=list_action");
    }
}

?>
