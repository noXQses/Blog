<?php

class GeneralController
{
    function error()
    {
        $error_page = new Template('views/error_view.html');
        $page = new TemplateService();
        $page->Together($error_page);
    }

    public function impressum()
    {
        $impressum_page = new Template('views/impressum_view.html');
        $page = new TemplateService();
        $page->Together($impressum_page);
    }

    public function kontakt()
    {
        $kontakt_page = new Template('views/kontakt_view.html');
        $page = new TemplateService();
        $page->Together($kontakt_page);
    }
}

?>
