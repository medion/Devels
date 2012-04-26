<?php

class Admin {
    function __construct($action,$id)
    {
        $this->load = new Load();
        $this->model = new Model();
        require './connect.inc.php';
        $rules = $_SESSION['rules'];
        if (isset($rules)&&$rules==1) {
            if ($action == 'edit') {
                $this->edit($id);
            } else if ($action == 'delete') {
                $this->delete($id);
            } else if ($action == 'add') {
                $this->add($_POST);
            }
        } else if (isset($rules)&&$rules==2) {
            if ($action == 'edit') {
                $this->edit($id);
            } else if ($action == 'delete') {
                $this->delete($id);
            } else if ($action == 'add') {
                $this->add($_POST);
            } else if ($action == 'users') {
                $this->users($_POST);
            } else if ($action == 'useredit') {
                $this->useredit($id);
            } else if ($action == 'userdel') {
                $this->userdel($id);
            }
        }
        else {
            header('Location: http://devels.loc/404');
        }
    }

    function edit($id) {
        $user_id = $_SESSION['user_id'];
        $rules = $_SESSION['rules'];
                if (isset($_POST['title_ua'])&&isset($_POST['text_ua'])&&isset($_POST['title_en'])&&isset($_POST['text_en'])) {
                    $title_ua = htmlspecialchars($_POST['title_ua']);
                    $text_ua = htmlspecialchars($_POST['text_ua']);
                    $title_en = htmlspecialchars($_POST['title_en']);
                    $text_en = htmlspecialchars($_POST['text_en']);
                    if (!empty($title_ua)&&!empty($text_ua)&&!empty($title_en)&&!empty($text_en)) {
                        $result = $this->model->adminupdatenewsedit($id,$title_ua,$text_ua,$title_en,$text_en,$user_id);//mysql_query("UPDATE news SET title_ua='".$title."', text_ua='".$text."' WHERE id = '".$id."'");
                        if ($result) {
                            header('Location: /news/view/'.$id);
                        } else {
                            echo 'При редагуванні сталася помилка';
                        }
                    } else {
                        $result = $this->model->adminSelectNewsEdit($id);//mysql_query("SELECT * FROM news WHERE id='".$id."'");
                        $data = $result;
                        $data['error_admin_edit_empty'] = 'Всі поля обов\'язкові для заповнення';
                    }
                } else {
                    if (isset($rules)&&isset($user_id)) {
                        if ($this->its_author($id)||$rules == 2) {
                            $result = $this->model->adminSelectNewsEdit($id);//mysql_query("SELECT * FROM news WHERE id='".$id."'");
                            if ($result) {
                                $data = $result;
                            } else {
                                header('Location: http://devels.loc/404');
                            }
                        } else {
                            header('Location: /404');
                        }
                    }
                }
                $this->load->view('admin/edit.php', $data);
    }

    function delete($id) {
        $user_id = $_SESSION['user_id'];
        $rules = $_SESSION['rules'];
        if (isset($rules)&&isset($user_id)) {
            if ($this->its_author($id)||$rules == 2) {
                $result = $this->model->getnews($id);
                if ($result) {
                    $delnews = $this->model->delnews($id);
                    if ($delnews) {
                        header('Location: http://devels.loc/news');
                    }
                } else {
                    header('Location: http://devels.loc/404');
                }
            }
        }
    }

    function add($_POST) {
        if (isset($_POST['title_ua'])&&isset($_POST['text_ua'])&&isset($_POST['title_en'])&&isset($_POST['text_en'])) {
            $title_ua = $_POST['title_ua'];
            $text_ua = $_POST['text_ua'];
            $title_en = $_POST['title_en'];
            $text_en = $_POST['text_en'];
            $author = $_SESSION['user_id'];
            //print_r($author);
            if (!empty($title_ua)&&!empty($text_ua)&&!empty($title_en)&&!empty($text_en)) {
                $result = $this->model->adminnewsadd($title_ua,$text_ua,$title_en,$text_en,$author);
                if($result) {
                    header('Location: /news');
                } else {
                    echo 'ERROR';
                }
            } else {
                $data['admin_news_empty_add'] = true;
            }
        }
        $this->load->view('admin/add.php', $data);
    }

    function users() {
        $data['list'] = $this->model->getallusers();
        $this->load->view('admin/users.php', $data);
    }

    function useredit($id) {
        if (isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['email'])&&isset($_POST['name'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $name = $_POST['name'];
            $rules = $_POST['rules'];
            if (!empty($_POST['password'])) {
                $password = $_POST['password'];
                $password_hash = md5($password);
                if (!empty($username)&&!empty($email)&&!empty($name)) {
                    $adminupduser_pass = $this->model->adminupduser_pass($id,$username,$password_hash,$email,$name,$rules);
                    //header('Location: /admin/useredit/'.$id);
                    $data['error_admin_useredit_empty'] = 'Всі поля обов\'язкові для заповненняss<br>';
                } else {
                    //$data['error_admin_useredit_empty'] = 'Всі поля обов\'язкові для заповнення';
                }
            } else if (empty($_POST['password'])) {
                if (!empty($username)&&!empty($email)&&!empty($name)) {
                    $adminupduser_nopass = $this->model->adminupduser_nopass($id,$username,$email,$name,$rules);
                    //$result = mysql_query("UPDATE users SET username='".$username."', email='".$email."', name='".$name."', rules='".$rules."' WHERE id = '".$id."'");
                    $data['error_admin_useredit_empty'] = 'Всі поля обов\'язкові для заповненняss<br>';
                    //header('Location: /admin/useredit/'.$id);
                }
                else {
                    $result = $this->model->getallusers_id($id);
                    if ($result) {
                        $data = $result;
                        $a = $data['rules'];
                        $data['s'.$a.''] = 'selected';
                        echo 'Зміни внесено';
                    }
                    $data['error_admin_useredit_empty'] = 'Всі поля обов\'язкові для заповненняss<br>';
                }
            }
        } else {
            //$result = mysql_query("SELECT * FROM users WHERE id='".$id."'");
            $result = $this->model->getallusers_id($id);
            if ($result) {
                $data = $result;
                $a = $data['rules'];
                $data['s'.$a.''] = 'selected';
                //echo 'Зміни внесено';
            } else {
                header('Location: http://devels.loc/404');
            }
        }
        $this->load->view('admin/useredit.php', $data);
    }

    function userdel($id) {
        //$result = mysql_query("SELECT * FROM users WHERE id='".$id."'");
        $result = $this->model->getinfuser($id);
        if ($result) {
            $result = $this->model->deluser($id);
        } else {
            header('Location: http://devels.loc/404');
        }
        $data['nick_del_user'] = $result['username'];
        $this->load->view('admin/userdel.php', $data);
    }
    
    
    function its_author($id) {
        $res = $this->model->getauthor($id);
        $user_id = $_SESSION['user_id'];
        if ($res['author'] == $user_id) {
            return true;
        } else {
            return false;
        }
    }

}

?>