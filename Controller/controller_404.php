<?php


class Controller_404 extends Controller
{
    public function __construct()
    {
        $this->view = new View();
        $this->UID = $_SESSION['login'];
    }

    public function action_index()
    {
        $this->view->generate('404_view.php', 'template_view.php','', $this->UID);
    }
}