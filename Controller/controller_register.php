<?php


class Controller_Register extends Controller
{
    public $error = array();
    public $message = array();
    public $email;
    public $name;
    public $password;
    public $db;

    public function __construct()
    {
        $this->model = new Model_Register();
        $this->view = new View();
        $this->db = $this->model->db;
        $this->UID = $_SESSION['login'];

    }

    public function action_index()
    {
        if($this->UID != null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }
            $this->view->generate('register_view.php', 'template_view.php');
    }

    public function action_register()
    {
        $response = array();
        if($this->UID != null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }

        $this->email = $_POST['email'];
        $this->name = $_POST['name'];
        $this->password = $_POST['password'];

        if (empty($this->email)) {
            $this->error[] = "Empty email";
        } else {
            $this->email = trim($this->email);
            if (filter_var($this->email, FILTER_VALIDATE_EMAIL) == false){
                $this->error[] = "Email is not valid";
            }else{
                $stmt = $this->db->run("SELECT COUNT(*) FROM users WHERE `email` = :email",['email' => $this->email]);
                $num_rows = $stmt->fetchColumn();
                if($num_rows > 0){
                    $this->error[] = "No unique email";
                }
            }
        }

        if (empty($this->name)){
            $this->error[] = "Empty name";
        }else{
            $this->name = trim($this->name);
        }

        if (empty($this->password)){
            $this->error[] = "Empty password";
        }else{
            $this->password = md5($this->password);
        }

        if (empty($this->error)) {

                $stmt = $this->db->run("INSERT INTO users (`email`, `name`, `password`) VALUES (:email, :name, :password)", [
                    'email' => $this->email,
                    'name' => $this->name,
                    'password' => $this->password
                ]) or die();
                $this->message[] = "Your registration was successful";

            foreach ($this->message as $message_item){
                $response['message'][] = "<div class='alert alert-primary' role='alert'>".$message_item. "</div>";
            }
        }else{
            foreach ($this->error as $error_item){
                $response['error'][] = "<div class='alert alert-danger' role='alert'>".$error_item. "</div>";
            }
        }
        echo json_encode($response);

    }
}