<?php

class Artikel
{
    private $artikel_id;
    private $blog_id;
    private $artikelname;
    private $inhalt;
    private $beschreibung;
    private $created_at;

    /**
     * @return mixed
     */
    public function getArtikelId()
    {
        return $this->artikel_id;
    }

    /**
     * @return mixed
     */
    public function getBlogId()
    {
        return $this->blog_id;
    }

    /**
     * @return mixed
     */
    public function getArtikelname()
    {
        return $this->artikelname;
    }

    /**
     * @return mixed
     */
    public function getInhalt()
    {
        return $this->inhalt;
    }

    /**
     * @return mixed
     */
    public function getBeschreibung()
    {
        return $this->beschreibung;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $blog_id
     */
    public function setBlogId($blog_id)
    {
        $this->blog_id = $blog_id;
    }

    /**
     * @param mixed $artikelname
     */
    public function setArtikelname($artikelname)
    {
        $this->artikelname = $artikelname;
    }

    /**
     * @param mixed $inhalt
     */
    public function setInhalt($inhalt)
    {
        $this->inhalt = $inhalt;
    }

    /**
     * @param mixed $beschreibung
     */
    public function setBeschreibung($beschreibung)
    {
        $this->beschreibung = $beschreibung;
    }

    //überarbeiten
    public function get_artikel_array()
    {
        return $ary = array($this->artikelname, $this->artikel_id, $this->blog_id, $this->beschreibung, $this->inhalt, $this->created_at);
    }

    public function set_artikel_array($artikelname, $artikel_id, $blog_id, $beschreibung, $created_at, $inhalt)
    {
        $this->artikelname = $artikelname;
        $this->beschreibung = $beschreibung;
        $this->inhalt = $inhalt;
        $this->artikel_id = $artikel_id;
        $this->blog_id = $blog_id;
        $this->created_at = $created_at;
    }
}