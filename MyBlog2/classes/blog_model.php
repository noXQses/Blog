<?php

class Blog
{
    private $blog_id;
    private $blogname;
    private $user_id;
    private $beschreibung;
    private $created_at;

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
    public function getBlogname()
    {
        return $this->blogname;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
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
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param mixed $blogname
     */
    public function setBlogname($blogname)
    {
        $this->blogname = $blogname;
    }

    /**
     * @param mixed $beschreibung
     */
    public function setBeschreiung($beschreibung)
    {
        $this->beschreiung = $beschreibung;
    }

    //überarbeiten
    public function get_blog_array()
    {
        return $ary = array($this->blogname, $this->blog_id, $this->user_id, $this->beschreibung, $this->created_at);
    }

    public function set_blog_array($blogname, $blog_id, $user_id, $beschreibung, $created_at)
    {
        $this->blogname = $blogname;
        $this->beschreibung = $beschreibung;
        $this->blog_id = $blog_id;
        $this->created_at = $created_at;
        $this->user_id = $user_id;
    }
}