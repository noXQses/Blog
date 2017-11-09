<?php
require_once ('classes/Template.php');
require_once ('classes/services/user_service.php');


class TemplateService
{
    public function Together($page)
    {
        $header = $this->get_header();
        $navigation = $this->get_navigation();
        $footer = $this->get_footer();

        $layout = new Template("views/layout.html");
        $layout->set("title", "MyBlog2");
        $layout->set("header", $header->output());
        $layout->set("navigation", $navigation->output());
        $layout->set("content", $page->output());
        $layout->set("footer", $footer->output());

        echo $layout->output();
    }

    private function get_header()
    {
        $userS = new UserService();
        $log_page = $userS->show_login_logout_view();

        $page = new Template('views/header_view.html');
        $page->set('login_logout_form', $log_page->output());

        return $page;
    }

    private function get_navigation()
    {
        $page = new Template('views/navigation_view.html');

        return $page;
    }

    private function get_footer()
    {
        $page = new Template('views/footer_view.html');

        return $page;
    }
}
?>
