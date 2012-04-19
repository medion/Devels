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
        } else if ($action == 'profile') {
            $this->profile();
        } else if ($action == 'edit') {
            $this->edit();
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
						// Змінюємо дату останнього входу
						$result = mysql_query("UPDATE users SET lastlogin = NOW(), countlogin = countlogin+1 WHERE id = '".$user_id."'");
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
            if (isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password_again'])&&isset($_POST['email'])&&
                isset($_POST['name'])) {
                $username       = $_POST['username'];
                $password       = $_POST['password'];
                $password_again = $_POST['password_again'];
                $password_hash  = md5($password);
				$email      	= $_POST['email'];
                $name      = $_POST['name'];
                if (!empty($username)&&!empty($password)&&!empty($password_again)&&!empty($email)&&!empty($name)) {
                    if (strlen($username)>20||strlen($name)>30) {
                        $data['error_max_lenght'] = true;
                    } else {
                        if ($password!=$password_again) {
                            $data['error_password_repeat'] = true;
                        } else {
                            $result = mysql_query("SELECT username FROM users WHERE username = '".$username."'");
                            if (mysql_num_rows($result)==1) {
                                $data['error_login_isset'] = true;
                            } else {
                                $result = mysql_query("INSERT INTO users VALUES ('','".mysql_real_escape_string($username)."','".mysql_real_escape_string($password_hash)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($name)."','pic1.jpg','',NOW(),NOW(),'1')");
								
								// Введені дані пройшли валідацію і занесені в базу, логінимо
                                if ($result) {
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
												header('Location: /');
											}
										}
									}
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
			$data['email'] = $email;
            $data['name'] = $name;
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
	
	
	function profile()
	{
		$user_id = $_SESSION['user_id'];
		$data['profile'] = $this->model->getprofile($user_id);
		$this->load->view('user/profile.php', $data);
	}
	
		function edit()
	{
		$user_id = $_SESSION['user_id'];
		$password       = $_POST['password'];
		$password_again = $_POST['password_again'];
		$password_hash  = md5($password);
		$name      = $_POST['name'];
		//print_r($_POST);
		if (empty($password)&&empty($password_again)&&!empty($name)) {
			if (strlen($name)>30) {
				$data['error_max_lenght'] = true;
			} else {
							$result = mysql_query("UPDATE users SET name='".mysql_real_escape_string($name)."' WHERE id = '".$user_id."'");
						
							if ($result) {
									$query = "SELECT * FROM users WHERE id = '".$user_id."'";
									
									if ($query_run = mysql_query($query))
									{
										$query_num_rows = mysql_num_rows($query_run);
										if ($query_num_rows==0)
										{
											$data['error_invalid_login_pass'] = true;
											echo 'err';
										} else if ($query_num_rows==1){
											$result = mysql_query("SELECT * FROM users WHERE id='".$user_id."'");
											if (mysql_num_rows($result) > 0) {
												$data = mysql_fetch_array($result, MYSQL_ASSOC);
											}
											$data['profile_pass_change'] = true;
										}
									}
                                } else {
                                    echo 'Відбулась помилка. Реєстрація не можлива';
                                }
							}
		} else if (!empty($password)&&!empty($password_again)) {
			if ($password!=$password_again) {
				$data['error_password_repeat'] = true;
			} else {
				$result = mysql_query("UPDATE users SET password='".$password_hash."' WHERE id = '".$user_id."'");
				if ($result) {
					$result = mysql_query("SELECT * FROM users WHERE id='".$user_id."'");
					if (mysql_num_rows($result) > 0) {
						$data = mysql_fetch_array($result, MYSQL_ASSOC);
					}
					$data['profile_pass_change'] = true;
				} else {
					header('Location: http://devels.loc/404');
				}
			}
		} else {
			$result = mysql_query("SELECT * FROM users WHERE id='".$user_id."'");
			if (mysql_num_rows($result) > 0) {
				$data = mysql_fetch_array($result, MYSQL_ASSOC);
			} else {
				header('Location: http://devels.loc/404');
			}
		}
		$this->load->view('user/edit.php', $data);
	}

	
	
    function loggedin()
    {
        if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
	
	function resize($photo_src, $width, $name){
		$parametr = getimagesize($photo_src);
		list($width_orig, $height_orig) = getimagesize($photo_src);
		$ratio_orig = $width_orig/$height_orig;
		$new_width = $width;
		$new_height = $width / $ratio_orig;
		$newpic = imagecreatetruecolor($new_width, $new_height);
		switch ( $parametr[2] ) {
			case 1: $image = imagecreatefromgif($photo_src);
				break;
			case 2: $image = imagecreatefromjpeg($photo_src);
				break;
			case 3: $image = imagecreatefrompng($photo_src);
				break;
		}
		imagecopyresampled($newpic, $image, 0, 0, 0, 0, $new_width, $new_height, $width_orig, $height_orig);
		imagejpeg($newpic, $name, 100);
		return true;
	}
	
}