<?php

class News {

    function __construct($controller,$action,$id)
    {
        $this->load = new Load();
        $this->model = new Model();
        if ($action == 'view') {
            $this->view($controller,$action,$id);
        } else {
            $this->index($controller,$action,$id);
        }
    }

    function index()
    {
        switch($_SESSION['lang']) :
            default: include('ua.php'); break;
            case 'ru': include('ru.php'); break;
            case 'en': include('en.php'); break;
        endswitch;
        $data['news'] = $this->model->getallnews();
        $id = $_SESSION['user_id'];
        $data['rules_link'] = $this->doit($id);
        if ($this->loggedin()) {
            $data['profile'] = "<a href='/user/profile'>".$lang['profile']."</a>";
        }
        $this->load->view('news_new.php', $data);
    }

    function view($controller,$action,$id)
    {
        switch($_SESSION['lang']) :
            default: include('ua.php'); break;
            case 'ru': include('ru.php'); break;
            case 'en': include('en.php'); break;
        endswitch;
        if (empty($id)) {
            header('Location: /404');
        }
        else
        {
            $user_id = $_SESSION['user_id'];
            $post_id = $id;
            // COMMENT
            if ($this->loggedin()) {
                if (isset($_POST['title'])&&isset($_POST['text'])) {
                    $title   = htmlspecialchars($_POST['title']);
                    $text    = htmlspecialchars($_POST['text']);
                    $user_id = $_SESSION['user_id'];
                    if (!empty($text)&&!empty($user_id)) {
                        $publication = mktime();
                        $post_id = $id;
                        $add_comm = $this->model->add_comm($post_id,$title,$text,$user_id,$publication); //Додаємо коментар
                        if ($add_comm) { $data_error['comm_add'] = true; }
                    } else{
                        $data_error['comm_empty_field'] = true;
                    }
                }
                $data_comm['comm_allow'] = true;
            }
            $result = $this->model->check_vote_db($user_id,$post_id);
            //print_r($result);
            if ($this->loggedin()) {
                if ($result) {
                    $data_vote = '0';
                } else {
                    if (isset($_POST['vote'])) {
                        //print_r($_POST);
                        $vote   = $_POST['vote'];
                        if (!empty($vote)&&!empty($post_id)&&!empty($user_id)) {
                            if($vote!='0') { // Користувач не вибрав оцінку
                                $add_vote = $this->model->add_vote($post_id,$user_id,$vote); //Додаємо голосування
                                if ($add_vote) {
                                    $data_error['vote_add'] = true;
                                    $data_error['vote_add_complite'] = 'Ваш голос зараховано';
                                }
                            }
                            else{
                                $data_vote = '1'; // Показуємо форму голосування
                                $data_error['vote_empty_field'] = true; // і повідомлення
                            }
                        } else{
                            $data_vote = '1';
                            $data_error['vote_err'] = true;
                        }
                    } else {
                        $data_vote = '1';
                    }
                }
            }
            
            $id = (int) $id;
            $data = $this->model->getnews($id);
            $data['comm_form'] = $data_comm; // Форма коментування
            $data['error'] = $data_error; // Помилки при коментуванні
            $data['vote_form'] = $data_vote; // Форма коментування
            $data['get_my_mark'] = $this->model->get_my_mark($user_id,$post_id);
            $data['author'] = $this->model->getauthorname($this->model->getauthor($id));
            // Середня оцінка по матеріалу
            $middle_vote = $this->model->get_vote($post_id);
            if ($middle_vote) {
                $count = count($middle_vote);
                foreach($middle_vote as $key => $value) {
                    $a = $a + $value['vote'];
                }
                $count_vote = count($middle_vote);
                $middle_vote = $a/$count_vote;
                $data['middle_vote'] = round($middle_vote, 2);
                $data['count_vote'] = $count;
            } else {
                $data['vote_no_mark'] = true;
            }

            if (empty($data)) {
                header('Location: /404');
            }
            $data['comments'] = $this->model->getcomments($id);
            
            if (isset($data['comments']))
            {
                foreach($data['comments'] as $comment => $value)
                {
                    $all[$value['id']] = $this->model->getcommname($value['user_id']);
                    $data['comments'][$comment]['username'] = $all[$value['id']]['username'];
                    $data['comments'][$comment]['publication'] = date('d-m-Y H:i:s', $data['comments'][$comment]['publication']);
                    if (empty($data['comments'][$comment]['title'])) {
                        $data['comments'][$comment]['title'] = $this->cutString($data['comments'][$comment]['text'],280);
                    }
                }
            }
            $id_for_rules = $_SESSION['user_id'];
            $data['rules_link'] = $this->doit($id_for_rules,$post_id);
            if ($this->loggedin()) {
                $data['profile'] = "<a href='/user/profile'>".$lang['profile']."</a>";
            }
            $this->load->view('news_view_new.php', $data);
        }
    }


    function check_admin($id) {
        $data = $this->model->getrules($id);
        if ($data['rules'] == 1){
            return true;
        } else {
            return false;
        }
    }
    
    function check_author($post_id) {
        $data = $this->model->getauthor($post_id);
        return $data['author'];
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

    function doit($id,$post_id=NULL)
    {
        switch($_SESSION['lang']) :
            default: include('ua.php'); break;
            case 'ru': include('ru.php'); break;
            case 'en': include('en.php'); break;
        endswitch;
        $id_user = $_SESSION['user_id'];
        $check_rul = $this->check_rules($id);
        $author = $this->check_author($post_id);
        //print_r($author);
        if($id_user == $author||$check_rul['rules']=='2') {
            $data['author_this'] = true;
        } else {
            $data['author_this'] = false;
        }
        
            switch($check_rul['rules'])
            {
                case 0:
                    $_SESSION['rules'] = $check_rul['rules'];
                    break;
                case 1:
                    $data['rules_link'] = "<a href='/admin/add'>".$lang['add_news']."</a>";
                    $_SESSION['rules'] = $check_rul['rules'];
                    $_SESSION['author'] = $author;
                    break;
                case 2:
                    $data['rules_link'] = "<a href='/admin/add'>".$lang['add_news']."</a><br><a href='/admin/users'>".$lang['user_management']."</a>";
                    $_SESSION['rules'] = $check_rul['rules'];
                    $_SESSION['rules_comm'] = $check_rul['rules_comm'];
                    break;
                case 3:
                    $_SESSION['rules'] = $check_rul['rules'];
                    $data['rules_link'] = "<span style='color:red'>".$lang['user_banned']."</span>";
                    break;
            }
        return $data;
    }
    
    
    

    function check_vote($user_id,$post_id) {
        $result = $this->model->check_vote_db($user_id,$post_id);
        //print_r($result);
    }

}

?>