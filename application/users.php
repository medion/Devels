<?php

class Users {
    public $load;
    public $model;
    
    function __construct($action)
    {
        $this->load = new Load();
        $this->model = new Model();
        require './connect.inc.php';
        if ($action == 'login') {
            $this->login($_POST);
        } else if ($action == 'logout') {
            $this->logout();
        } else if ($action == 'registration') {
            $this->registration();
        } else if ($action == 'registration_done') {
            $this->registration_done();
        }

    }

    function login($_POST) 
    {
        if (isset($_POST['username'])&&isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password_hash = md5($password);
            if (!empty($username)&&!empty($password)) {
                $query = "SELECT id FROM users WHERE username='".mysql_real_escape_string($username)."' AND password='".mysql_real_escape_string($password_hash)."'";
                if ($query_run = mysql_query($query)) {
                    $query_num_rows = mysql_num_rows($query_run);
                    if ($query_num_rows==0) {
                        $data['error_invalid_login_pass'] = true;
                        $this->load->view('login.php', $data);
                    } else if ($query_num_rows==1){
                        $user_id = mysql_result($query_run, 0, 'id');
                        $_SESSION['user_id'] = $user_id;
                        if($_SERVER['HTTP_REFERER'] == 'http://devels.loc/user/login') {
                            header('Location: /');
                        } else {
                            header('Location: '.$_SERVER['HTTP_REFERER']);
                        }
                        
                    }
                }
            } else {
            $data['error_empty_login_pass'] = true;
            $this->load->view('login.php', $data);
            }
        }
    }

    function logout()
    {
        unset($_SESSION['user_id']);
		unset($_SESSION['admin']);
		unset($_SESSION['rules']);
		unset($_SESSION['is_admin']);
		unset($_SESSION['user_id']);
		unset($_SESSION['lang']);
        header('Location: '.$_SERVER['HTTP_REFERER']);
	
    }
    
    
    
    
    function registration()
    {
        if (!$this->loggedin()) {
            if (isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password_again'])&&
                isset($_POST['firstname'])&&isset($_POST['surname'])) {
                $username       = $_POST['username'];
                $password       = $_POST['password'];
                $password_again = $_POST['password_again'];
                $password_hash  = md5($password);
                $firstname      = $_POST['firstname'];
                $surname        = $_POST['surname'];
                if (!empty($username)&&!empty($password)&&!empty($password_again)&&!empty($firstname)&&!empty($surname)) {
                    if (strlen($username)>20||strlen($firstname)>30||strlen($surname)>30) {
                        $data['error_max_lenght'] = true;
                    } else {
                        if ($password!=$password_again) {
                            $data['error_password_repeat'] = true;
                        } else {
                            $result = mysql_query("SELECT username FROM users WHERE username = '".$username."'");
                            if (mysql_num_rows($result)==1) {
                                $data['error_login_isset'] = true;
                            } else {
                                $result = mysql_query("INSERT INTO users VALUES ('','".mysql_real_escape_string($username)."','".mysql_real_escape_string($password_hash)."','".mysql_real_escape_string($firstname)."','".mysql_real_escape_string($surname)."','')");
                                if ($result) {
                                    header('Location: registration_done');
                                } else {
                                    echo 'Відбулась помилка. Реєстрація не можлива';
                                }
                            }
                        }
                    }
                } else {
                    $data['error_empty'] = true;
                }
            }
            $data['username'] = $username;
            $data['firstname'] = $firstname;
            $data['surname'] = $surname;
            $this->load->view('registration.php', $data);
        } else if ($this->loggedin()) {
            $data['reg_already_registered'] = true;
            $this->load->view('registration.php', $data);
        }
    }

	function registration_done()
    {
        $this->load->view('reg_done.php');
    }
	
    function loggedin()
    {
        if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}