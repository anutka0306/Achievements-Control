<?php


class Controller_Achievement extends Controller
{
    public $error = array();
    public $message = array();
    public $db;
    public $host;


    public function __construct()
    {
        $this->model = new Model_Achievement();
        $this->view = new View();
        $this->db = $this->model->db;
        $this->UID = $_SESSION['login'];
        $this->host = 'http://'.$_SERVER['HTTP_HOST'].'/';
    }

    public function action_index()
    {
        header('Location:'.$this->host.'404');
    }

    public function action_area($id=null){
        if($this->UID == null){
            header('Location:'.$this->host);
        }
        $data = $this->model->get_achievement($id);
        if(!empty($data['info'])) {
            $this->view->generate('achievement_view.php', 'template_view.php', $data, $this->UID);
        }else{
            header('Location:'.$this->host.'404');
        }
    }

    public function action_add_action($id){
        if($this->UID == null){
            header('Location:'.$this->host);
        }

        try {
            $data = $this->model->add_action($id, $_POST['actionName'],$_POST['actionMeasure']);
            if($data) {
                $this->message[] = "Новое действие успешно добавлено";
            }else{
                $this->error[] = "Действие с таким именем уже существует в данной зоне.";
            }
        }catch (PDOException $e){
            $this->error[] = "Ошибка добавления нового действия";
        }

        if(empty($this->error)){
            $_SESSION['messages'] = $this->message;
        }else{
            $_SESSION['errors'] = $this->error;
        }
        header('Location:'.$this->host.'achievement/area/'.$id);


    }

    public function action_delete_action($id){
        if($this->UID == null){
            header('Location:'.$this->host);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $area_id = $this->model->get_area_id_by_action_id($id);
            $area_id = $area_id['ach_area_id'];
            try {
                $this->model->delete_action($id);
                $this->message[] = "Действие успешно удалено.";

            } catch (PDOException $e) {
                $this->error[] = "Ошибка удаления действия.";
            }

            if (empty($this->error)) {
                $_SESSION['messages'] = $this->message;
            } else {
                $_SESSION['errors'] = $this->error;
            }
            header('Location:' . $this->host . 'achievement/area/' . $area_id);
        }else{
            header('Location:'.$this->host.'404');
        }
    }

    public function action_edit_action($id){
        if($this->UID == null){
            header('Location:'.$this->host);
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $area_id = $this->model->get_area_id_by_action_id($id);
            $area_id = $area_id['ach_area_id'];
            try {
                $this->model->edit_action($id, $_POST['actionEditName'], $_POST['actionEditMeasure']);
                $this->message[] = "Действие успешно отредактировано.";
            }catch (PDOException $e){
                $this->error[] = "Ошибка редактирования действия.";
            }
            if (empty($this->error)) {
                $_SESSION['messages'] = $this->message;
            } else {
                $_SESSION['errors'] = $this->error;
            }
            header('Location:' . $this->host . 'achievement/area/' . $area_id);
        }else{
            header('Location:'.$this->host.'404');
        }
    }
}