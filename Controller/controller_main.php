<?php


class Controller_Main extends Controller
{
   public function  __construct()
    {
        $this->model = new Model_Main();
        $this->view = new View();
        $this->UID = $_SESSION['login'];
    }

   public function action_index()
    {
        $data = $this->model->get_data();
        $this->view->generate('main_view.php', 'template_view.php', $data, $this->UID);
    }
    public function action_out()
    {
        unset($_SESSION['login']);
        header('Location: http://'.$_SERVER['HTTP_HOST'].'/');
    }
}