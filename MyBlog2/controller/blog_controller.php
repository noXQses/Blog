<?php
require_once('classes/services/blog_service.php');

class BlogController
{
    public function list_action()
    {
        $data = new BlogService();
        $data = $data->loadAllBlogs();

        $blogs = array();

        foreach($data as $blog)
        {
            $blogs[] = array(
                "name" => $blog->getBlogname(),
                "beschreibung" => $blog->getBeschreibung(),
                "blog_id" => $blog->getBlogId(),
                "url" => "artikel",
                "controller" => "artikel",
                "action" => "list_action",
                "buttonTitle" => "Blog lesen"
            );
        }

        foreach($blogs as $blog)
        {
            $row = new Template('views/list_action_rows_view.html');

            foreach($blog as $key => $value)
            {
                $row->set($key, $value);
            }

            if((isset($_SESSION['admin']) ? $_SESSION['admin'] : false) === true)
            {
                $loeschen_page = new Template('views/list_action_loeschen_view.html');

                $loeschen_page->set("url", "blog_loeschen");
                $loeschen_page->set("controller", "blog");
                $loeschen_page->set("action", "blog_loeschen");
                $loeschen_page->set("artikel_id", "");
                $loeschen_page->set("blog_id", $blog['blog_id']);
                $loeschen_page->set("buttonTitle", "Blog löschen");

                $row->set('loeschen', $loeschen_page->output());
            }
            else
            {
                $row->set('loeschen', "");
            }

            $blogsTemplate[] = $row;
        }

        $blogsContents = Template::merge($blogsTemplate);

        $blog_list = new Template('views/list_action_view.html');
        $blog_list->set('title', 'MyBlog');
        $blog_list->set('header', 'Alle Blogs in der Übersicht');
        if((isset($_SESSION['admin']) ? $_SESSION['admin'] : false) === true)
        {
            $neu_page = new Template('views/list_action_neu_view.html');
            $neu_page->set('url', "blog_neu");
            $neu_page->set('controller', "blog");
            $neu_page->set('action', "blog_neu");
            $neu_page->set('blog_id', "");
            $neu_page->set('buttonTitle', "Neuen Blog erstellen");

            $blog_list->set('neu', $neu_page->output());
        }
        else
        {
            $blog_list->set('neu', "");
        }
        $blog_list->set('Contents', $blogsContents);

        $teSe = new TemplateService();
        $teSe->Together($blog_list);
    }

    public function blog_neu()
    {
        $name = isset ($_POST['blog_neu_name']) ? $_POST['blog_neu_name'] : "?!?..leer";
        $beschreibung = isset ($_POST['blog_neu_beschreibung']) ? $_POST['blog_neu_beschreibung'] : "";

        $bloSe = new BlogService();
        $bloSe->blog_neu_page($name, $beschreibung);

        $page = new Template('views/blog_neu_view.html');
        $teSe = new TemplateService();
        $teSe->Together($page);
    }

    public function blog_loeschen()
    {
        $blog_id = $_POST['blog_id'];

        $bloSe = new BlogService();
        $bloSe->blog_loeschen($blog_id);

        header('Location: http://localhost:8080/MyBlog2/index.php?startseite?controller=blog&action=list_action');
    }
}

?>
