<?php

class Vote {
    
    function __construct($controller,$action,$vote)
    {
        $this->load = new Load();
        $this->model = new Model();
        require './connect.inc.php';
        $rules = $_SESSION['rules'];
        if (isset($rules)&&$rules==2) {
            if ($action == 'change') {
                $this->change($vote);
            } else if ($action == 'del') {
                $this->del($vote);
            }
        } else {
            header('Location: http://devels.loc/404');
        }

    }
    
    function change($vote) {
        //echo 'change '.$post_id;
        $data['news'] = $vote;
        $data['vote'] = $this->model->get_vote($vote);
        //print_r($data['vote']);
        foreach($data['vote'] as $key => $value) {
            $all['username'] = $this->model->getcommname($value['user_id']);
            $data['vote'][$key]['username'] = $all['username'];
        }
        //print_r($data);
        $this->load->view('vote/change.php',$data);
    }
    
    function del($vote) {
        //$result = mysql_query("SELECT * FROM users WHERE id='".$vote."'");
        $result = $this->model->get_vote_one($vote);
        //print_r($result);
        if($result) {
            $delvote = $this->model->del_vote_one($vote);
            //print_r($delvote);
        }
        //if (mysql_num_rows($result) > 0) {
        //    $row = mysql_fetch_array($result, MYSQL_ASSOC);
        //    $result = mysql_query("DELETE FROM users WHERE id='".$vote."'");
        //} else {
        //    header('Location: http://devels.loc/404');
        //}
        header('Location: '.$_SERVER["HTTP_REFERER"]);
    }

}