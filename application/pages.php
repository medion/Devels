<?php

class Pages {
    public $load;
    public $model;
	
    function __construct($alias)
	{
		$this->load = new Load();
		$this->model = new Model();
		$this->view($alias);      
	}
   
    function view($alias)
    {
        if (empty($alias)) {
            header('Location: /404');
        }
        else
        {
			$alias = htmlspecialchars($alias);
            $data = $this->model->getpage($alias);
            if (empty($data)) {
                header('Location: /404');
            }
			$id = $_SESSION['user_id'];
			if ($this->loggedin()) {
				$data['profile'] = '<a href="/user/profile">Профиль</a>';
			}
			$data['rules_link'] = $this->doit($id);
            $this->load->view('pages_view_new.php', $data);
       }
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