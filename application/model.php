<?php

class Model {

    /*
    public function getallnews() {
        $result = mysql_query('SELECT * FROM news');
        while($row = mysql_fetch_assoc($result))
        {
            $data[] = $row;
        };
        return $data;
    }
    */
    public function getallnews() { //PDO
        global $db;
        $result = $db->query('SELECT * FROM news');
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return $data;
    }
    
    /*
    public function getnews($id) {
        $result = mysql_query('SELECT * FROM news WHERE id = '.$id);
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        return $row;
    }
    */
    public function getnews($id) {
        global $db;
        $result = $db->query("SELECT * FROM news WHERE id = '".$id."'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }

    public function getmainnews() { //PDO
        global $db;
        $result = $db->query('SELECT * FROM news');
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            $data[] = $row;
        }
        return $data;
    }

    /*
    public function getpage($alias) {
        $result = mysql_query("SELECT * FROM pages WHERE alias = '".$alias."'");
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        return $row;
    }
    */
    public function getpage($alias) { //PDO
        global $db;
        $result = $db->query("SELECT * FROM pages WHERE alias = '".$alias."'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }
    
    /*
    public function getrules($id) {
        $result = mysql_query("SELECT rules FROM users WHERE id = '".$id."'");
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        return $row;
    }
    */   
    public function getrules($id) { //PDO
        global $db;
        $result = $db->query("SELECT rules FROM users WHERE id = '".$id."'");
        $row = $result->fetchColumn();
        return $row;
    }

    
    
    /* USERS */
    
    public function check_username($username) {
        global $db;
        $result = $db->query("SELECT count(*) FROM users WHERE username='".$username."'");
        $row = $result->fetch(PDO::FETCH_NUM);
        return $row[0];
    }

    public function add_username($username,$password_hash,$email,$name,$upfilename,$firstlogin,$lastlogin) {
        global $db;
        $result = $db->query("INSERT INTO users (id,username,password,email,name,avatar,rules,firstlogin,lastlogin,countlogin) VALUES ('','".$username."','".$password_hash."','".$email."','".$name."','".$upfilename."','','".$firstlogin."','".$lastlogin."','1')");
        return $result;
    }
    
    public function get_user($username,$password_hash) {
        global $db;
        $result = $db->query("SELECT id FROM users WHERE username = '".$username."' AND password = '".$password_hash."'");
        $row = $result->fetchColumn();
        return $row;
    }
    
    public function do_login($username,$password_hash) {
        global $db;
        $result = $db->query("SELECT id FROM users WHERE username = '".$username."' AND password = '".$password_hash."'");
        $row = $result->fetch(PDO::FETCH_NUM);
        return $row[0];
    }
    
    public function timeupdate($user_id,$lastlogin) {
        global $db;
        $db->exec("UPDATE users SET lastlogin = '".$lastlogin."', countlogin = countlogin+1 WHERE id = '".$user_id."'");
    }
    
    
    /* PROFILE */
    
    /*
    public function getprofile($user_id) {
        $result = mysql_query("SELECT * FROM users WHERE id = '".$user_id."'");
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        return $row;
    }*/
    
    public function getprofile($user_id) {
        global $db;
        $result = $db->query("SELECT * FROM users WHERE id = '".$user_id."'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }
    
    /* COMMENTS */
    
    public function add_comm($post_id,$title,$text,$user_id,$publication) {
        global $db;
        $result = $db->query("INSERT INTO comment (id,post_id,title,text,user_id,publication) VALUES ('','".$post_id."','".$title."','".$text."','".$user_id."','".$publication."')");
        return $result;
    }
    
    public function getcomments($post_id) {
        global $db;
        $result = $db->query("SELECT * FROM comment WHERE post_id = '".$post_id."' ORDER BY publication DESC");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function getcommname($user_id) {
        global $db;
        $result = $db->query("SELECT DISTINCT username FROM users WHERE id = '".$user_id."'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }
    
    public function commdel($post_id) {
        global $db;
        $result = $db->exec("DELETE FROM comment WHERE id = '".$post_id."'");
        return $result;
    }
    
    /* USER EDIT */
    
    function getinfuser($user_id) {
        global $db;
        $result = $db->query("SELECT * FROM users WHERE id = '".$user_id."'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }
    
    function upduserinfo($name,$user_id) {
        global $db;
        $upduserinfo = $db->exec("UPDATE users SET name = '".$name."' WHERE id = '".$user_id."'");
        return $upduserinfo;
    }
    
    function selall($user_id) {
        global $db;
        $result = $db->query("SELECT * FROM users WHERE id = '".$user_id."'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }
    
    function changpass($password_hash,$user_id) {
        //$changpass = mysql_query("UPDATE users SET password='".$password_hash."' WHERE id = '".$user_id."'");
        global $db;
        $changpass = $db->exec("UPDATE users SET password = '".$password_hash."' WHERE id = '".$user_id."'");
        return $changpass;
        
    }
    
    /* ADMIN USERS */
    
    /*
    public function getallusers() {
        $result = mysql_query('SELECT * FROM users');
        while($row = mysql_fetch_assoc($result))
        {
            $data[] = $row;
        };
        return $data;
    }
    */
    
    function getallusers() {
        global $db;
        $result = $db->query("SELECT * FROM users");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
    
    function getallusers_id($id) {
        global $db;
        $result = $db->query("SELECT * FROM users WHERE id = '".$id."'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }
    
    function adminupduser_pass($user_id,$username,$password_hash,$email,$name,$rules) {
        //$result = mysql_query("UPDATE users SET username='".$username."', password='".$password_hash."', email='".$email."', name='".$name."', rules='".$rules."' WHERE id = '".$id."'");
        global $db;
        $adminupduser = $db->exec("UPDATE users SET username = '".$username."', password='".$password_hash."', email='".$email."', name='".$name."', rules='".$rules."' WHERE id = '".$user_id."'");
        return $adminupduser;
    }
    
    function adminupduser_nopass($user_id,$username,$email,$name,$rules) {
        //$result = mysql_query("UPDATE users SET username='".$username."', email='".$email."', name='".$name."', rules='".$rules."' WHERE id = '".$id."'");
        global $db;
        $adminupduser = $db->exec("UPDATE users SET username = '".$username."', email='".$email."', name='".$name."', rules='".$rules."' WHERE id = '".$user_id."'");
        return $adminupduser;
    }
    
    /* ADMIN NEWS ADD */
    
    function adminnewsadd($title_ua,$text_ua,$title_en,$text_en) {
        global $db;
        $result = $db->query("INSERT INTO news (id,title_ua,text_ua,title_ru,text_ru,title_en,text_en) VALUES ('','".$title_ua."','".$text_ua."','','','".$title_en."','".$text_en."')");
        return $result;
    }
    
    /* ADIN NEWS EDIT */
    
    function adminSelectNewsEdit($id) {
        //$result = mysql_query("SELECT * FROM news WHERE id='".$id."'");
        global $db;
        $result = $db->query("SELECT * FROM news WHERE id = '".$id."'");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data = $row;
        }
        return $data;
    }
    
    function adminUpdateNewsEdit($id,$title_ua,$text_ua,$title_en,$text_en) {
        //$result = mysql_query("UPDATE news SET title_ua='".$title."', text_ua='".$text."' WHERE id = '".$id."'");
        global $db;
        $adminupduser = $db->exec("UPDATE news SET title_ua = '".$title_ua."', text_ua='".$text_ua."', title_en='".$title_en."', text_en='".$text_en."' WHERE id = '".$id."'");
        return $adminupduser;
    }
    
    
    /* VOTE */
    public function add_vote($post_id,$user_id,$vote) {
        global $db;
        $result = $db->query("INSERT INTO vote (id,post_id,user_id,vote) VALUES ('','".$post_id."','".$user_id."','".$vote."')");
        return $result;
    }
    
    public function check_vote_db($user_id,$post_id) {
        global $db;
        $result = $db->query("SELECT vote FROM vote WHERE user_id = '".$user_id."' AND post_id = '".$post_id."'");
        $row = $result->fetch(PDO::FETCH_NUM);
        return $row;
    }
    
    function get_my_mark($user_id,$post_id) {
        global $db;
        $result = $db->query("SELECT vote FROM vote WHERE user_id = '".$user_id."' AND post_id = '".$post_id."'");
        $row = $result->fetch(PDO::FETCH_NUM);
        return $row[0];
    }
    
    function getmiddle_vote($post_id) {
        global $db;
        $query = "SELECT * FROM vote WHERE post_id = '".$post_id."'";
        $res = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
        // $res - массив всей выборки, каждая строка представлена ассоциативным массивом
        return $res;
    }
    
}