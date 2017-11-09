<?php
require_once('classes/services/artikel_service.php');

class ArtikelController
{
    public function list_action()
    {
        require_once('classes/services/blog_service.php');

        $arSe = new ArtikelService();
        $blog_id = isset ($_POST['blog_id']) ? $_POST['blog_id'] : $_GET['blog_id'];
        $data = $arSe->loadArticles($blog_id);

        $artikel = array();

        foreach($data as $art)
        {
            $artikel[] = array(
                "name" => $art->getArtikelname(),
                "beschreibung" => $art->getBeschreibung(),
                "artikel_id" => $art->getArtikelId(),
                "blog_id" => $art->getBlogId(),
                "url" => "artikel_details",
                "controller" => "artikel_details",
                "action" => "list_action",
                "buttonTitle" => "Artikel lesen"
            );
        }

        $counter = 0;

        foreach($artikel as $arti)
        {
            $row = new Template('views/list_action_rows_view.html');

            foreach($arti as $key => $value)
            {
                $row->set($key, $value);
            }

            if((isset($_SESSION['admin']) ? $_SESSION['admin'] : false) === true)
            {
                $loeschen_page = new Template('views/list_action_loeschen_view.html');

                $loeschen_page->set("url", "artikel_loeschen");
                $loeschen_page->set("controller", "artikel");
                $loeschen_page->set("action", "artikel_loeschen");
                $loeschen_page->set("artikel_id", $data[$counter]->getArtikelId());
                $loeschen_page->set("blog_id", $data[$counter]->getBlogId());
                $loeschen_page->set("buttonTitle", "Artikel löschen");

                $counter++;

                $row->set('loeschen', $loeschen_page->output());
            }
            else
            {
                $row->set('loeschen', "");
            }

            $artikelTemplate[] = $row;
        }

        $blogsContents = Template::merge($artikelTemplate);

        $get_name = new BlogService();
        $blog_id = $data[0]->getBlogId();
        $blogname = $get_name->get_blogname($blog_id);

        $artikel_list = new Template('views/list_action_view.html');
        $artikel_list->set('title', $blogname['blogname']);


        $artikel_list->set('header', 'Alle Artikel von ' . $blogname['blogname'] . ' in der Übersicht');
        if((isset($_SESSION['admin']) ? $_SESSION['admin'] : false) === true)
        {
            $neu_page = new Template('views/list_action_neu_view.html');
            $neu_page->set('url', "artikel_neu");
            $neu_page->set('controller', "artikel");
            $neu_page->set('action', "artikel_neu");
            $neu_page->set('blog_id', $blog_id);
            $neu_page->set('buttonTitle', "Neuen Artikel erstellen");

            $artikel_list->set('neu', $neu_page->output());
        }
        else
        {
            $artikel_list->set('neu', "");
        }
        $artikel_list->set('Contents', $blogsContents);

        $teSe = new TemplateService();
        $teSe->Together($artikel_list);
    }

    public function artikel_neu()
    {
        $name = isset ($_POST['artikel_neu_name']) ? $_POST['artikel_neu_name'] : "?!?..leer";
        $beschreibung = isset ($_POST['artikel_neu_beschreibung']) ? $_POST['artikel_neu_beschreibung'] : "";
        $inhalt = isset ($_POST['artikel_neu_text']) ? $_POST['artikel_neu_text'] : "";
        $blog_id = isset ($_POST['blog_id']) ? $_POST['blog_id'] : "";

        $arSe = new ArtikelService();
        $arSe->artikel_neu_page($name, $beschreibung, $inhalt, $blog_id);

        $page = new Template('views/artikel_neu_view.html');
        $page->set('blog_id', $blog_id);
        $teSe = new TemplateService();
        $teSe->Together($page);
    }

    public function artikel_loeschen()
    {
        $arSe = new ArtikelService();
        $arSe->artikel_loeschen($_POST['artikel_id']);

        header('Location: http://localhost:8080/MyBlog2/index.php?controller=artikel&action=list_action&blog_id=' . $_POST['blog_id']);
    }
}
