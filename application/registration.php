<?php
require 'connect.inc.php';

function loggedin() {
    if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }


if (!loggedin()) {
    if (isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['password_again'])&&
        isset($_POST['firstname'])&&isset($_POST['surname'])) {
        $username       = $_POST['username'];
        $password       = $_POST['password'];
        $password_again = $_POST['password_again'];
        $password_hash  = md5($password);
        $firstname      = $_POST['firstname'];
        $surname        = $_POST['surname'];
        if (!empty($username)&&!empty($password)&&!empty($password_again)&&!empty($firstname)&&!empty($surname)) {
            if (strlen($username)>20||strlen($firstname)>30||strlen($surname)>30) {
                $data['error_max_lenght'] = '������� ������� ����� �������� ����������� ���������.';
            } else {
                if ($password!=$password_again) {
                    $data['error_password_repeat'] = '������ � ���������� ������ �� ����������';
                } else {
                    $result = mysql_query("SELECT username FROM users WHERE username = '".$username."'");
                    if (mysql_num_rows($result)==1) {
                        echo '���� <strong>'.$username.'</strong> ��� ����';
                    } else {
                        $result = mysql_query("INSERT INTO users VALUES ('','".mysql_real_escape_string($username)."','".mysql_real_escape_string($password_hash)."','".mysql_real_escape_string($firstname)."','".mysql_real_escape_string($surname)."')");                    
                        if ($result) {
                            header('Location: registration_done');
                        } else {
                            echo '³������� �������. ��������� �� �������';
                        }
                    }
                }
            }
        } else {
            $data['error_empty'] = '�� ���� ������ ���� ��������';
        }
    }
?>



<?php
} else if (loggedin()) {
    echo '�� ����������� � ���������';
}

?>




























