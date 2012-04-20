<?php

class Admin {

    function __construct($action,$id)
    {
        $this->load = new Load();
        $this->model = new Model();
        require './connect.inc.php';
        $rules = $_SESSION['rules'];
        if (isset($rules)&&$rules==1||$rules==2) {
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
        $id = mysql_real_escape_string($id);
        if (isset($_POST['title'])&&isset($_POST['text'])) {
            $title = strip_tags($_POST['title'], '<p><a><img>');
            $text = strip_tags($_POST['text'], '<p><a><img>');
            if (!empty($title)&&!empty($text)) {
                $result = mysql_query("UPDATE news SET title_ua='".$title."', text_ua='".$text."' WHERE id = '".$id."'");
                header('Location: /news/view/'.$id);
            } else {
                $result = mysql_query("SELECT * FROM news WHERE id='".$id."'");
                $data = mysql_fetch_array($result, MYSQL_ASSOC);
                $data['error_admin_edit_empty'] = 'Всі поля обов\'язкові для заповнення';
            }
        } else {
            $result = mysql_query("SELECT * FROM news WHERE id='".$id."'");
            if (mysql_num_rows($result) > 0) {
                $data = mysql_fetch_array($result, MYSQL_ASSOC);
            } else {
                header('Location: http://devels.loc/404');
            }
        }
        $this->load->view('admin/edit.php', $data);
    }

    function delete($id) {
        $id = mysql_real_escape_string($id);
        $result = mysql_query("SELECT * FROM news WHERE id='".$id."'");
        if (mysql_num_rows($result) > 0) {
            $data = mysql_fetch_array($result, MYSQL_ASSOC);
            $result = mysql_query("DELETE FROM news WHERE id='".$id."'");
            if ($result) {
                header('Location: http://devels.loc/news');
            }
        } else {
            header('Location: http://devels.loc/404');
        }
    }

    function add() {
        if (isset($_POST['title_ua'])&&isset($_POST['text_ua'])&&isset($_POST['title_en'])&&isset($_POST['text_en'])) {
            $title_ua = $_POST['title_ua'];
            $text_ua = $_POST['text_ua'];
            $title_en = $_POST['title_en'];
            $text_en = $_POST['text_en'];
            if (!empty($title_ua)&&!empty($text_ua)&&!empty($title_en)&&!empty($text_en)) {
                $result = mysql_query("INSERT INTO news VALUES ('','".mysql_real_escape_string($title_ua)."','".mysql_real_escape_string($text_ua)."','','','".mysql_real_escape_string($title_en)."','".mysql_real_escape_string($text_en)."')");
                header('Location: /news');
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
                    $result = mysql_query("UPDATE users SET username='".$username."', password='".$password_hash."', email='".$email."', name='".$name."', rules='".$rules."' WHERE id = '".$id."'");
                    header('Location: /admin/useredit/'.$id);
                } else {
                    $data['error_admin_useredit_empty'] = 'Всі поля обов\'язкові для заповнення';
                }
            } else if (empty($_POST['password'])) {
                if (!empty($username)&&!empty($email)&&!empty($name)) {
                    $result = mysql_query("UPDATE users SET username='".$username."', email='".$email."', name='".$name."', rules='".$rules."' WHERE id = '".$id."'");
                    header('Location: /admin/useredit/'.$id);
                }
                else {
                    $result = mysql_query("SELECT * FROM users WHERE id='".$id."'");
                    if (mysql_num_rows($result) > 0) {
                        $data = mysql_fetch_array($result, MYSQL_ASSOC);
                        $a = $data['rules'];
                        $data['s'.$a.''] = 'selected';
                    }
                    $data['error_admin_useredit_empty'] = 'Всі поля обов\'язкові для заповненняss<br>';
                }
            }
        } else {
            $result = mysql_query("SELECT * FROM users WHERE id='".$id."'");
            if (mysql_num_rows($result) > 0) {
                $data = mysql_fetch_array($result, MYSQL_ASSOC);
                $a = $data['rules'];
                $data['s'.$a.''] = 'selected';
            } else {
                header('Location: http://devels.loc/404');
            }
        }
        $this->load->view('admin/useredit.php', $data);
    }

    function userdel($id) {
        $result = mysql_query("SELECT * FROM users WHERE id='".$id."'");
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $result = mysql_query("DELETE FROM users WHERE id='".$id."'");
        } else {
            header('Location: http://devels.loc/404');
        }
        $data['nick_del_user'] = $row['username'];
        $this->load->view('admin/userdel.php', $data);
    }

}

?>