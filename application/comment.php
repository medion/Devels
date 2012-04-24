<?php

class Comment {
    
    function __construct($controller,$action,$post_id)
    {
        $this->load = new Load();
        $this->model = new Model();
        require './connect.inc.php';
        if ($action == 'add') {
            $this->add($_POST,$post_id);
        } else if ($action == 'del') {
            $this->del($post_id);
        }
    }
    
    function add($_POST,$post_id) {
        print_r($_POST);
        if ($this->loggedin()) {
            if (isset($_POST['title'])&&isset($_POST['text'])&&isset($_POST['user_id'])) {
                $title   = $_POST['title'];
                $text    = $_POST['text'];
                $user_id = $_POST['user_id'];
                if (!empty($title)&&!empty($text)&&!empty($user_id)) {
                    $publication = mktime();
                    echo 'asd';
                } else{
                    $data['comm_empty_field'] = true;
                }
            }
        } else {
            echo 'ERROR';
        }
    }
    
    function del($post_id) {
        $result = $this->model->commdel($post_id);
        //print_r($result);
        if ($result) {
            //echo 'Comment del';
            header('Location: '.$_SERVER['HTTP_REFERER']);
        } else {
            echo 'Error';
        }
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