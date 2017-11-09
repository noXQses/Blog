<?php
require_once('classes/services/artikel_service.php');

class ArtikelDetailsController
{
    public function list_action()
    {
        $artikel_id = isset($_POST['artikel_id']) ? $_POST['artikel_id'] : "";

        if($artikel_id !== "")
        {
            $arSe = new ArtikelService();
            $artikel = $arSe->loadArticleDetails($artikel_id);

            $detail_page = new Template('views/artikel_details_view.html');

            $detail_page->set('artikelname', $artikel[0]->getArtikelname());
            $detail_page->set('beschreibung', $artikel[0]->getBeschreibung());
            $detail_page->set('inhalt', $artikel[0]->getInhalt());

            $page = new TemplateService();
            $page->Together($detail_page);
        }
        else
        {
            header("Location: http://localhost:8080/MyBlog2/index.php?controller=general&action=error");
        }
    }
}

?>
