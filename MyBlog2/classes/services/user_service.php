<?php
require_once('classes/user_model.php');

class UserService
{

    function loadAllUser()
    {
        //Optimierung: Daten per constructor übergeben

        $database = new Database();

        $database->query('SELECT username, password, user_id, admin FROM user');
        $database->execute();

        $rows = $database->resultset();

        $users = array();

        foreach ($rows as $row) {
            $new_user = new User();
            $new_user->setUserArray($row['username'], $row['password'], $row['user_id'], $row['admin']);

            $users[] = $new_user;
        }

        return $users;
    }


    function getSingleUser($username)
    {
        $database = new Database();

        $database->query('SELECT username, password, user_id, admin FROM user WHERE username ="' . $username . '"');
        $database->execute();

        $user = $database->resultset();

        return $user;
    }


    function getAllUsernames()
    {
        $userServ = new UserService();

        $users = $userServ->loadAllUser();
        $usernames = array();

        foreach ($users as $row) {
            $new_user = $row->getUsername();
            $usernames[] = $new_user;
        }

        return $usernames;
    }


    function get_pepper()
    {
        $database = new Database();

        $database->query('SELECT pepper FROM pepper');
        $database->execute();

        $pepper = $database->single();

        return $pepper['pepper'];
    }


    function get_user_id($username)
    {
        $database = new Database();

        $database->query('SELECT user_id FROM user WHERE username = :username');
        $database->bind(':username', $username);
        $database->execute();

        $user_id = $database->single();

        return (int)$user_id;
    }

//----------------------------------------ANMELDUNG---------------------------------------------------------------------

    function check_new_user_input()
    {
        $username = isset($_POST['username']) ? $_POST['username'] : "";
        $password = isset($_POST['password']) ? $_POST['password'] : "";
        $password2 = isset($_POST['password2']) ? $_POST['password2'] : "";

        if ((isset($_POST['admin']) ? $_POST['admin'] : "off") === "on") {
            $admin = 1;
        } else {
            $admin = 0;
        }

        if ($username !== "" && $password !== "" && $password2 !== "" && $password === $password2) {
            $userS = new UserService();

            if ($userS->check_unique_user($username)) {
                $userS->set_new_user($username, $password, $admin);
                echo '<a href="http://localhost:8080/MyBlog2/index.php?startseite?controller=blog&action=list_action" >Zurück zur Startseite</a>';
            } else {
                //echo "<br> Der Benutzername ist bereits vergeben.";
            }
        } else {
            //echo "<br> Bitte füllen Sie das Anmeldeformular vollständig aus und klicken Sie auf Registrieren";
        }
    }


    function check_unique_user($username)
    {
        $userS = new UserService();
        $unique = false;
        $new_user = $_POST['username'];
        $username = $userS->getAllUsernames();

        foreach ($username as $name) {
            if ($new_user === $name) {
                $unique = false;
                break;
            } else {
                $unique = true;
            }
        }

        return $unique;
    }


    function set_new_user($username, $password, $admin)
    {
        $database = new Database();
        $userS = new UserService();

        $pw = password_hash($password . $userS->get_pepper(), PASSWORD_BCRYPT);

        $database->query('INSERT INTO user (username, password, admin) VALUES (:username, :password, :admin)');

        $database->bind(':username', $username);
        $database->bind(':password', $pw);
        $database->bind(':admin', $admin);

        $database->execute();
    }

//------------------------------LOGIN-----------------------------------------------------------------------------------

    function check_login()
    {
        $usernameFe = isset($_POST['username']) ? $_POST['username'] : "";
        $passwordFe = isset($_POST['password']) ? $_POST['password'] : "";
        $logged = isset($_SESSION['logged']) ? $_SESSION['logged'] : false;
        $admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : 0;

        $userS = new UserService();

        if ($usernameFe != "" && $passwordFe != "" && $logged === false) {
            if ($userS->getSingleUser($usernameFe) != NULL) {
                $user = $userS->getSingleUser($usernameFe);

                if (password_verify($passwordFe . $userS->get_pepper(), $user[0]['password'])) {
                    $_SESSION['logged'] = true;
                    $_SESSION['username'] = $usernameFe;

                    if ($user[0]['admin'] == 1) {
                        $_SESSION['admin'] = true;
                    }
                    else {
                        $_SESSION['admin'] = false;
                    }
                    #vorerst raus bis location klar ist
                    #header("Location: http://localhost:8080/MyBlog/index.php?controller=pages&action=" . $_POST['last_page'] . "&blog_id=" . $_POST['blog_id'] . "&artikel_id=" . $_POST['artikel_id']);
                    return true;
                }
                else {
                    $_SESSION['logged'] = false;
                    $_SESSION['admin'] = false;
                    return false;
                }
            }
            else {
                $_SESSION['logged'] = false;
                $_SESSION['admin'] = false;
                return false;
            }
        } else {
            $_SESSION['logged'] = false;
            $_SESSION['admin'] = false;
            return false;
        }
    }


    function show_login_logout_view()
    {
        $logged = isset($_SESSION['logged']) ? $_SESSION['logged'] : false;

        if ($logged)
        {
            return $login_page = new Template('views/user_logout_view.html');
        }
        else
        {
            return $login_page = new Template('views/user_login_view.html');
        }
    }
}

?>
