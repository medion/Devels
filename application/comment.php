<?php

class Comment {
    
    function __construct($controller,$action,$id)
    {
        $this->load = new Load();
        $this->model = new Model();
        require './connect.inc.php';
        if ($action == 'add') {
            $this->add($_POST,$id);
        } else if ($action == 'del') {
            $this->del($id);
        } else if ($action == 'confirm') {
            $this->confirm($id);
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
    
    function del($id) {
        $result = $this->model->getcomm($id);
        $this->load->view('comment/del.php',$result);
    }
    
    function confirm($id) {
        //print_r($id);
        $refer = $this->model->getpagecomm($id);
        $result = $this->model->commdelete($id);
        if (!$result) {
            header('Location: /404');
        }
        $this->load->view('comment/delcomplite.php',$refer);
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