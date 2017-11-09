<?php
require_once('classes/blog_model.php');

class BlogService
{

    function __construct()
    {
    }

    function loadAllBlogs()
    {
        //Optimierung: Daten per constructor übergeben

        $database = new Database();

        $database->query('SELECT blogname, blog_id, user_id, beschreibung, created_at FROM blogs');
        $database->execute();

        $rows = $database->resultset();

        $blogs = array();

        foreach ($rows as $row) {
            $new_blog = new Blog();
            $new_blog->set_blog_array($row['blogname'], $row['blog_id'], $row['user_id'], $row['beschreibung'], $row['created_at']);

            $blogs[] = $new_blog;
        }

        return $blogs;
    }


    function get_blogname($blog_id)
    {
        $database = new Database();

        $database->query('SELECT blogname FROM blogs WHERE blog_id= :blog_id');
        $database->bind(':blog_id', $blog_id);
        $database->execute();

        $blogname = $database->single();

        return $blogname;
    }


    function blog_neu_page($blogname, $beschreibung)
    {
        if ($blogname == "" || $blogname == "?!?..leer" || $beschreibung == "") {
            if ($blogname == "?!?..leer") {
                echo "";
            } else {
                echo "Ihre Eingaben sind ungültig. Bitte füllen Sie alle Felder aus";
            }
        }
        else
        {
            $bloSe = new BlogService();
            if ($bloSe->check_unique($blogname)) {
                echo "Neuer Blog erfolgreich erstellt";
                $bloSe->blog_erstellen($blogname, $beschreibung);
                header('Location: index.php?Startseite');
            } else {
                echo "Der Blogname ist bereits vergeben.";
            }
        }
    }


    function blog_erstellen($blogname, $teaser, $user_id = 1)
    {
        $database = new Database();

        $database->query('INSERT INTO blogs (blogname, beschreibung, user_id) VALUES (:blogname, :beschreibung, :user_id)');
        $database->bind(':blogname', $blogname);
        $database->bind(':beschreibung', $teaser);
        $database->bind(':user_id', $user_id);

        $database->execute();
    }


    function check_unique($neuer_blogname)
    {
        $bloSe = new BlogService();
        $alle_blogs = $bloSe->loadAllBlogs();
        $blog_unique = false;

        foreach ($alle_blogs as $blognamen) {
            if ($blognamen->getBlogname() == $neuer_blogname) {
                $blog_unique = false;
                break;
            } else {
                $blog_unique = true;
            }
        }

        return $blog_unique;
    }

    function blog_loeschen($blog_id)
    {
        $database = new Database();

        $database->beginTransaction();
        $database->query('DELETE FROM blogs WHERE blog_id = :blog_id');
        $database->bind(':blog_id', $blog_id);
        $database->execute();
        $database->query('DELETE FROM artikel WHERE blog_id = :blog_id');
        $database->bind(':blog_id', $blog_id);
        $database->execute();
        $database->endTransaction();
    }


}

?>
