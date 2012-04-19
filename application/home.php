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
		//if ($this->check_rules($id)) {
		//	$data['admin'] = '<a href="/admin/add">Додати новину</a>';
		//	$_SESSION['rules'] = 1;
		//}
		
		//print_r($this->check_rules($id));
		$data['rules_link'] = $this->doit($id);
		
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
	
	function check_rules($id) {
		$data = $this->model->getrules($id);
		return $data;
	}
	
	
	function loggedin() {
    if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
	
	function doit($id)
	{
		$check_rul = $this->check_rules($id);
		switch($check_rul['rules'])
		{
			case 0:
				echo '<p>Користувач</p>';
				$_SESSION['rules'] = $check_rul['rules'];
				break;
			case 1:
				echo '<p>Редактор</p>';
				$data['rules_link'] = '<a href="/admin/add">Додати новину</a>';
				$_SESSION['rules'] = $check_rul['rules'];
				break;
			case 2:
				echo '<p>Адмін</p>';
				$data['rules_link'] = '<a href="/admin/add">Додати новину</a><br><a href="/admin/users">Управління користувачами</a>';
				$_SESSION['rules'] = $check_rul['rules'];
				break;
			case 3:
				echo '<p>Заблокований</p>';
				$_SESSION['rules'] = $check_rul['rules'];
				break;
		}
		return $data;
	}

}
