<?php


class Controller_Dashboard extends Controller
{
    public $error = array();
    public $message = array();
    public $db;
    public $areaName;
    public $areaDescription;
    public $start_date;

    public function __construct()
    {
        $this->model = new Model_Dashboard();
        $this->view = new View();
        $this->db = $this->model->db;
        $this->UID = $_SESSION['login'];
    }

    public function action_index()
    {
        if($this->UID == null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }
        $data = $this->model->get_data();
        $this->view->generate('dashboard_view.php', 'template_view.php', $data, $this->UID);
    }

    /*public function action_achievement($id){
        if($this->UID == null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }
        $data = $this->model->get_achievement($id);
        $this->view->generate('achievement_view.php', 'template_view.php', $data, $this->UID);
    }*/

    public function action_create_area(){
        if($this->UID == null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }
        $response = array();
        $this->areaName = $_POST['areaName'];
        $this->areaDescription = $_POST['areaDescription'];
        try {
            $data = $this->model->create_achievement_area($this->UID, $this->areaName, $this->areaDescription);
            if($data) {
                $response['data'] = $data;
                $this->message[] = "Новая зона успешно добавлена";
            }else{
                $this->error[] = "Зона с таким именем уже существует. Придумайте другое имя для зоны или удалите существующую.";
            }
        }catch (PDOException $e){
            $this->error[] = "Ошибка добавления новой зоны";
        }

        if(empty($this->error)) {
            foreach ($this->message as $message_item) {
                $response['message'][] = "<div class='alert alert-primary' role='alert'>" . $message_item . "</div>";
            }
        }else {
            foreach ($this->error as $error_item) {
                $response['error'][] = "<div class='alert alert-danger' role='alert'>" . $error_item . "</div>";
            }
        }
        echo json_encode($response);
    }

    /**
     * @param $id
     */
    public function action_delete_area($id){
        $response = array();
        if($this->UID == null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }
        try {
            $this->model->delete_achievement_area($id);
            $this->message[] = "Зона успешно удалена";

        }catch (PDOException $e){
            $this->error[] = "Ошибка удаления зоны";
        }

        if(empty($this->error)) {
            foreach ($this->message as $message_item) {
                $response['message'][] = "<div class='alert alert-primary' role='alert'>" . $message_item . "</div>";
            }
        }else {
            foreach ($this->error as $error_item) {
                $response['error'][] = "<div class='alert alert-danger' role='alert'>" . $error_item . "</div>";
            }
        }

        echo json_encode($response);

    }

    public function action_complete_area($id){
        $response = array();
        if($this->UID == null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }
        try {
           $data =  $this->model->complete_achievement_area($id);
           $response['data'] = $data;
            $this->message[] = "Зона завершена";
        }catch (PDOException $e){
            $this->error[] = "Ошибка завершения зоны";
        }
        if(empty($this->error)) {
            foreach ($this->message as $message_item) {
                $response['message'][] = "<div class='alert alert-primary' role='alert'>" . $message_item . "</div>";
            }
        }else {
            foreach ($this->error as $error_item) {
                $response['error'][] = "<div class='alert alert-danger' role='alert'>" . $error_item . "</div>";
            }
        }
        echo json_encode($response);

    }

    public function action_edit_area($id){
        if($this->UID == null){
            header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
        }
        $response = array();
        $this->areaName = $_POST['areaName'];
        $this->areaDescription = $_POST['areaDescription'];
        $this->start_date = $_POST['startDate'];
        try {
           $data = $this->model->edit_achievement_area($id, $this->areaName, $this->areaDescription, $this->start_date, $this->UID);
           if($data) {
               $response['data'] = $data;
               $this->message[] = "Зона успешно отредактирована";
           }else{
               $this->error[] = "Зона с таким именем уже существует. Придумайте другое имя для зоны или удалите существующую.";
           }
        }catch (PDOException $e){
            $this->error[] = "Ошибка редактирования зоны";
        }

        if(empty($this->error)) {
            foreach ($this->message as $message_item) {
                $response['message'][] = "<div class='alert alert-primary' role='alert'>" . $message_item . "</div>";
            }
        }else {
            foreach ($this->error as $error_item) {
                $response['error'][] = "<div class='alert alert-danger' role='alert'>" . $error_item . "</div>";
            }
        }

        echo json_encode($response);

    }

}