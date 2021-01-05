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
            $this->error[] = "Ошибка добавления новой зоны";
        }

        if(empty($this->error)){
            header('Location:'.$this->host.'achievement/area/'.$id);
        }else{
            //Подумать, как вывести ошибку
            echo "ERROR";
        }


    }


}