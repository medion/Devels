<?php

class Home {

    function __construct($http)
    {
        $this->load = new Load();
        $this->model = new Model();
        $this->index($http);
    }

    function index($http)
    {
        //$this->model->user_info();
        switch($_SESSION['lang']) :
            default: include('ua.php'); break;
            case 'ru': include('ru.php'); break;
            case 'en': include('en.php'); break;
        endswitch;
        $data['news'] = $this->model->getmainnews();
        //unset($_SESSION['user_id']);
		$id = $_SESSION['user_id'];
		//print_r($data2);
		if ($this->check_admin($id)) {
			$data['admin'] = '<a href="/admin/add">Додати новину</a>';
			$_SESSION['rules'] = 1;
		}
		
		if ($this->loggedin()) {
			$data['profile'] = '<a href="/user/profile">Профиль</a>';
		}
		
		//print_r($this->check_admin($id));
		//print_r($_SESSION);
		//print_r($data);
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

}
