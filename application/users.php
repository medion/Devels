<?php

class Users {
    public $load;
    public $model;
    
    function __construct($action,$id)
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
        } else if ($action == 'view_profile') {
            $this->view_profile($id);
        }
    }

    function login($_POST) 
    {
        if (isset($_POST['username'])&&isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password_hash = md5($password);
            if (!empty($username)&&!empty($password)) {
                $result = $this->model->do_login($username,$password_hash); //Перевіримо, чи їснує такий користувач
                    if (!empty($result)) {
                        $user_id = $result;
                        $_SESSION['user_id'] = $user_id;
                        $lastlogin = mktime();
                        $dateupdate = $this->model->timeupdate($user_id,$lastlogin); //mysql_query("UPDATE users SET lastlogin = NOW(), countlogin = countlogin+1 WHERE id = '".$user_id."'");
                        if($_SERVER['HTTP_REFERER'] == 'http://devels.loc/user/login') {
                            header('Location: /');
                        } else {
                            header('Location: '.$_SERVER['HTTP_REFERER']);
                        }
                    } else {
                        $data['error_invalid_login_pass'] = true;
                        $this->load->view('login.php', $data);
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
                unset($_SESSION['rules_comm']);
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
                $name           = $_POST['name'];
                if (!empty($username)&&!empty($password)&&!empty($password_again)&&!empty($email)&&!empty($name)) {
                    if (strlen($username)>20||strlen($name)>30) {
                        $data['error_max_lenght'] = true;
                    } else {
                        if ($password!=$password_again) {
                            $data['error_password_repeat'] = true;
                        } else {
                            $result = $this->model->check_username($username); //Перевіримо, чи їснує такий користувач
                            if ($result == 1) {
                                $data['error_login_isset'] = true;
                            } else {
                                $upfilename = $this->upload($_FILES);
                                if (empty($upfilename)) { $upfilename = 'default.jpg'; }
                                $upfile = './uploads/avatar/'.$upfilename;
                                //print_r($upfile);
                                $this->img_resize($upfile, $upfile, 150, 150,  70, 0xFFFFF0, 0);
                                //print_r($a);
                                
                                
                                
                                $firstlogin = mktime();
                                $lastlogin = mktime();
                                
                                $result2 = $this->model->add_username($username,$password_hash,$email,$name,$upfilename,$firstlogin,$lastlogin); //Додаємо користувача
                                
                                // Введені дані пройшли валідацію і занесені в базу, логінимо
                                if ($result2) {
                                    $getuser = $this->model->get_user($username,$password_hash); //ІД користувача

                                    if(!empty($getuser)) {
                                        $user_id = $getuser;
                                        $_SESSION['user_id'] = $user_id;
                                        if($_SERVER['HTTP_REFERER'] == 'http://devels.loc/user/login') {
                                                header('Location: /');
                                        } else {
                                                header('Location: /');
                                        }
                                    } else {
                                        $data['error_invalid_login_pass'] = true;
                                        $this->load->view('login.php', $data);
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
        //print_r($data['profile']);

        $data['profile']['firstlogin'] = date('d-m-Y H:i:s',$data['profile']['firstlogin']);
        $data['profile']['lastlogin'] = date('d-m-Y H:i:s',$data['profile']['lastlogin']);
        $this->load->view('user/profile.php', $data);
    }
    
    function view_profile($id)
    {
        //echo 'sss '.$id;
        $data['profile'] = $this->model->getprofile($id);
        $user_id = $_SESSION['user_id'];
        if ($user_id == $id) {
            $data['profile']['my_profile'] = true;
        } else {
            $data['profile']['my_profile'] = false;
        }
        $this->load->view('user/view_profile.php', $data);
    }

    function edit()
    {
            $user_id = $_SESSION['user_id'];
            $password       = $_POST['password'];
            $password_again = $_POST['password_again'];
            $password_hash  = md5($password);
            $name      = $_POST['name'];
            if (empty($password)&&empty($password_again)&&!empty($name)) {
                    if (strlen($name)>30) {
                            $data['error_max_lenght'] = true;
                    } else {
                        $upduserinfo = $this->model->upduserinfo($name,$user_id);
                            if ($upduserinfo) {
                                            $getinfuser = $this->model->getinfuser($user_id);
                                            if ($getinfuser) {
                                                $result = $this->model->selall($user_id);
                                                if ($result) {
                                                        $data = $result;
                                                }
                                                $data['profile_pass_change'] = true;
                                            } else {
                                                $data['error_invalid_login_pass'] = true;
                                                echo 'err';
                                            }
                            } else {
                                $selall = $this->model->selall($user_id);
                                    if ($selall) {
                                            $data = $selall;
                                    }
                                echo 'Змін у профілі не має.';
                            }
                                                    }
            } else if (!empty($password)&&!empty($password_again)) {
                    if ($password!=$password_again) {
                            $data['error_password_repeat'] = true;
                    } else {
                            $changpass = $this->model->changpass($password_hash,$user_id);
                            if ($changpass) {
                                    $selall = $this->model->selall($user_id);
                                    if ($selall) {
                                            $data = $selall;
                                    }
                                    $data['profile_pass_change'] = true;
                            } else {
                                    header('Location: http://devels.loc/404');
                            }
                    }
            } else {
                    $selall = $this->model->selall($user_id);
                    if ($selall) {
                            $data = $selall;
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

    function img_resize($src, $dest, $width, $height,  $quality, $rgb=0xFFFFFF, $fon=0)
    {
        if (!file_exists($src)) return false;

        $size = getimagesize($src);

	if ($size === false) return false;
	$quality = (int)$quality;
	$width = (int)$width;
	$height = (int)$height;

	$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));

	$icfunc = "imagecreatefrom" . $format;

	if (!function_exists($icfunc)) return false;

	$x_ratio = $width / $size[0];
	$y_ratio = $height / $size[1];

	$ratio       = min($x_ratio, $y_ratio);
	$use_x_ratio = ($x_ratio == $ratio);

	$new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
	$new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
	$new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
	$new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);


	$isrc = $icfunc($src);

        $new_left    = 0; 
        $new_top     = 0; 
        $idest = imagecreatetruecolor($new_width, $new_height);

	imagefill($idest, 0, 0, $rgb);
	imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);

	imagejpeg($idest, $dest, $quality);

	imagedestroy($isrc);
	imagedestroy($idest);

	return true;
    }




    function filename($length = 12){
        $chars = 'abcdefghijklmnoprstuvwxyz123456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
	
	
    function upload($_FILES) {
        if($_FILES['avatar']['tmp_name']&&$_FILES['avatar']['error']==0)
        {
            if ($_FILES['size']['tmp_name'] < 1024*2*1024) {
                    // Перевіримо чи дійсно завантажуваний файл зображення
                    $imageinfo = getimagesize($_FILES['avatar']['tmp_name']);
                            if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png')
                            {
                                    $data['error_image_type'] = true;
                                    $newfilename = 'default.jpg';
                                    $data['error_image_type'] = 'ERROR IMG';
                            }
                            else
                            {
                                    $uploaddir = './uploads/avatar/';
                                    $filename = $_FILES['avatar']['name'];
                                    $newfilename = $this->filename().'.'.end(explode(".", $filename));;
                                    $uploadfile = $uploaddir.$newfilename;
                                    $mimetype = $_FILES['avatar']['type'];
                                    if (!copy($_FILES['avatar']['tmp_name'], $uploadfile))
                                    {
                                            echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
                                    }
                                    return $newfilename;
                            }
            }
        }
    }
	
	
}