<?php

Class Admin
{
	function __construct($action,$id)
    {
        $this->load = new Load();
        $this->model = new Model();
        require './connect.inc.php';
        if ($action == 'edit') {
            $this->edit($id);
        } else if ($action == 'delete') {
            $this->delete($id);
        } else if ($action == 'add') {
            $this->add(_POST);
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
		//	print_r($data);
			
			$result = mysql_query("DELETE FROM news WHERE id='".$id."'");
			
			if ($result) {
				header('Location: http://devels.loc/news');
			}
			
		} else {
			header('Location: http://devels.loc/404');
		}
	}
	
	function add() {
		if (isset($_POST['title'])&&isset($_POST['text'])) {
			$title = $_POST['title'];
            $text = $_POST['text'];
            if (!empty($title)&&!empty($text)) {
                $result = mysql_query("INSERT INTO news VALUES ('','".mysql_real_escape_string($title)."','".mysql_real_escape_string($text)."','','','','')");
				header('Location: /news');
            } else {
				$data['error_admin_add_empty'] = 'Введіть заголовок і текст новини';
            }
		}
		$this->load->view('admin/add.php', $data);
	}

}

?>