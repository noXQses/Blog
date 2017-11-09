<?php
require_once('classes/artikel_model.php');

class ArtikelService
{

    public function __construct()
    {
    }

    function loadArticles($blog_id)
    {
        $database = new Database();

        $database->query('SELECT artikelname, artikel_id, blog_id, beschreibung, created_at, inhalt FROM artikel WHERE blog_id = :blog_id');
        $database->bind(':blog_id', $blog_id);
        $database->execute();

        $rows = $database->resultset();

        $artikel = array();

        foreach ($rows as $row)
        {
            $new_artikel = new Artikel();
            $new_artikel->set_artikel_array($row['artikelname'], $row['artikel_id'], $row['blog_id'], $row['beschreibung'], $row['created_at'], $row['inhalt']);

            $artikel[] = $new_artikel;
        }

        return $artikel;
    }


    function loadArticleDetails($artikel_id)
    {
        $database = new Database();

        $database->query('SELECT artikelname, artikel_id, blog_id, beschreibung, created_at, inhalt FROM artikel WHERE artikel_id = :artikel_id');
        $database->bind(':artikel_id', $artikel_id);
        $database->execute();

        $rows = $database->resultset();

        $artikel = array();

        foreach ($rows as $row)
        {
            $new_artikel = new Artikel();
            $new_artikel->set_artikel_array($row['artikelname'], $row['artikel_id'], $row['blog_id'], $row['beschreibung'], $row['created_at'], $row['inhalt']);

            $artikel[] = $new_artikel;
        }

        return $artikel;
    }


    function artikel_loeschen($artikel_id)
    {
        $database = new Database();

        $database->beginTransaction();
        $database->query('DELETE FROM artikel WHERE artikel_id = :artikel_id');
        $database->bind(':artikel_id', $artikel_id);
        $database->execute();
        $database->endTransaction();
    }


    function artikel_neu_page($artikelname, $beschreibung, $inhalt, $blog_id)
    {
        if($artikelname == "" || $artikelname == "?!?..leer" || $beschreibung == "" || $inhalt == "")
        {
            if($artikelname == "?!?..leer")
            {
                echo "";
            }
            else
            {
                echo "Ihre Eingaben sind ungültig. Bitte füllen Sie alle Felder aus";
            }
        }
        else
        {
            $arSe = new ArtikelService();
            if($arSe->check_unique_article($artikelname, $blog_id))
            {
                $arSe->artikel_erstellen($artikelname, $beschreibung, $inhalt, $blog_id);
                header('Location: http://localhost:8080/MyBlog2/index.php?controller=artikel&action=list_action&blog_id=' . $blog_id);
            }
            else
            {
                echo "Der Artikelname ist bereits vergeben.";
            }
        }
    }


    function artikel_erstellen($artikelname, $beschreibung, $inhalt, $blog_id)
    {
        $database = new Database();

        $database->query('INSERT INTO artikel (artikelname, beschreibung, inhalt, blog_id) VALUES (:artikelname, :beschreibung, :inhalt, :blog_id)');
        $database->bind(':artikelname', $artikelname);
        $database->bind(':beschreibung', $beschreibung);
        $database->bind(':inhalt', $inhalt);
        $database->bind(':blog_id', $blog_id);

        $database->execute();
    }


    function check_unique_article($neuer_artikelname, $blog_id)
    {
        $arSe = new ArtikelService();
        $alle_artikel = $arSe->loadArticles($blog_id);
        $artikel_unique = false;

        if($alle_artikel == NULL)
        {
            $artikel_unique = true;
        }
        else
        {
            foreach($alle_artikel as $artikelnamen)
            {
                if($artikelnamen->getArtikelname() == $neuer_artikelname)
                {
                    $artikel_unique = false;
                    break;
                }
                else
                {
                    $artikel_unique = true;
                }
            }
        }

        return $artikel_unique;
    }
}

?>
