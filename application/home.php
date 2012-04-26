<?php

class Home {

    function __construct($http)
    {
        global $db;
        $this->load = new Load();
        $this->model = new Model();
        $this->index($http);
    }

    function index($http)
    {
        switch($_SESSION['lang']) :
            default: include('ua.php'); break;
            case 'ru': include('ru.php'); break;
            case 'en': include('en.php'); break;
        endswitch;
        $data['news'] = $this->model->getmainnews();
        $id = $_SESSION['user_id'];
        $data['rules_link'] = $this->doit($id);
        if ($this->loggedin()) {
            $data['profile'] = "<a href='/user/profile'>".$lang['profile']."</a>";
        }
        $this->load->view('index_new.php', $data);
    }
	
    function check_admin($id) {
        $data = $this->model->getrules($id);
        if ($data['rules'] == 1){
            return true;
        }
        else {
            return false;
        }
    }

    function loggedin() {
        if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
	
    function check_rules($id) {
        $data = $this->model->getrules($id);
        return $data;
    }
	
    function doit($id)
    {
        switch($_SESSION['lang']) :
            default: include('ua.php'); break;
            case 'ru': include('ru.php'); break;
            case 'en': include('en.php'); break;
        endswitch;
        $check_rul = $this->check_rules($id);
        switch($check_rul['rules'])
        {
            case 0:
                $_SESSION['rules'] = $check_rul['rules'];
                break;
            case 1:
                $data['rules_link'] = "<a href='/admin/add'>".$lang['add_news']."</a>";
                $_SESSION['rules'] = $check_rul['rules'];
                break;
            case 2:
                $data['rules_link'] = "<a href='/admin/add'>".$lang['add_news']."</a><br><a href='/admin/users'>".$lang['user_management']."</a>";
                $_SESSION['rules'] = $check_rul['rules'];
                break;
            case 3:
                $_SESSION['rules'] = $check_rul['rules'];
                $data['rules_link'] = "<span style='color:red'>".$lang['user_banned']."</span>";
                break;
        }
        return $data;
    }

}

?>