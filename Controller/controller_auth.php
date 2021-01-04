<?php


class Controller_Auth extends Controller
{
    public $error = array();
    public $message = array();
    public $email;
    public $password;
    public $db;

    public function __construct()
    {
        $this->model = new Model_Auth();
        $this->view = new View();
        $this->db = $this->model->db;
        $this->UID = $_SESSION['login'];
    }

    public function action_index()
    {
        if($this->UID != null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }
            $this->view->generate('auth_view.php', 'template_view.php');
    }

    public function action_auth(){
        $response = array();

        if($this->UID != null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }

        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
        if($this->checkLogin($this->email)){
            if($user = $this->checkPassword($this->email, $this->password)){
                $_SESSION['login'] = $user->id;
                $response['UID'] = $user->id;
                $this->message[] = "Welcome, ".$user->name;
            }
        }
        if(!empty($this->error)){
            foreach ($this->error as $error_item){
                $response['message'][] = "<div class='alert alert-danger' role='alert'>".$error_item. "</div>";
            }
        }else{
            foreach ($this->message as $message_item){
                $response['message'][] = "<div class='alert alert-primary' role='alert'>".$message_item. "</div>";
            }
        }
        echo json_encode($response);
    }

    private function checkLogin($email){
        if (!empty($email)) {
            $stmt = $this->db->run("SELECT * FROM `users` WHERE `email` = :email", ['email' => $email]);
            $num_rows = $stmt->fetchColumn();
            if ($num_rows > 0) {
                return true;
            } else {
                $this->error[] = "Your e-mail doesn't register in system";
                return false;
            }
        }else{
            $this->error[] = "E-mail is empty";
        }
    }

    private function checkPassword($email, $password){
        if(!empty($password)) {
            $stmt = $this->db->run("SELECT * FROM `users` WHERE `email` = :email", ['email' => $email]);
            $result = $stmt->fetch(PDO::FETCH_LAZY);
            if ($result->password == md5($password)) {
                $this->message[] = 'Pass correct';
                return $result;
            } else {
                $this->error[] = 'Pass incorrect';
                return false;
            }
        }else{
            $this->error[] = 'Password is empty';
        }
    }
}