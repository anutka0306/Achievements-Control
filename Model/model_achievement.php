<?php


class Model_Achievement extends Model
{
    public function get_data()
    {
        parent::get_data(); // TODO: Change the autogenerated stub
    }

    public function get_achievement($id){
        $data = [];
        $data['info'] =  $this->db->getRow("SELECT * FROM `ach_area` JOIN `area_status` ON status_id = ach_area.status WHERE `id` = :id AND `user_id` = :user_id", ['id' =>$id, 'user_id' =>$this->UID]);
        $data['actions'] = $this->db->getRows("SELECT ach_actions.*, action_measure.measure FROM `ach_actions` JOIN `action_measure` ON action_measure.id = ach_actions.mesure_id WHERE `ach_area_id` = :id",['id' => $id]);
        $data['measures'] = $this->db->getRows("SELECT * FROM `action_measure`");

        return $data;

    }

    public function add_action($id, $name, $measure){
        $has_name = $this->db->getRow("SELECT COUNT(*) as `count` FROM `ach_actions` WHERE `ach_area_id` = :id && `name` = :name", ['id'=> $id, 'name' => $name]);
        if($has_name['count'] == 0) {
            $this->db->run("INSERT INTO `ach_actions` (`ach_area_id`, `name`, `mesure_id`) VALUES(:id, :name, :measure)", ['id' => $id, 'name' => $name, 'measure' => $measure]);
            $id = $this->db->lastInsertId();
            return $this->get_achievement($id);
        }else{
            return false;
        }
    }

}