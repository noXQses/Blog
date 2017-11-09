<?php

class User
{
    private $username;
    private $password;
    private $user_id;
    private $admin;


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    //überarbeiten
    public function getUserArray()
    {
        return $ary = array($this->username, $this->password, $this->user_id, $this->admin);
    }

    public function setUserArray($username, $password, $user_id, $admin)
    {
        $this->username = $username;
        $this->password = $password;
        $this->user_id = $user_id;
        $this->admin = $admin;
    }
}