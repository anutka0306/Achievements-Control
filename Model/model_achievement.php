<?php


class Model_Achievement extends Model
{
    public function get_data()
    {
        parent::get_data(); // TODO: Change the autogenerated stub
    }

    public function get_achievement($id){
        $data = [];
        $chats_in = [];
        $data['info'] =  $this->db->getRow("SELECT * FROM `ach_area` JOIN `area_status` ON status_id = ach_area.status WHERE `id` = :id AND `user_id` = :user_id", ['id' =>$id, 'user_id' =>$this->UID]);
        $data['actions'] = $this->db->getRows("SELECT ach_actions.*, action_measure.measure FROM `ach_actions` JOIN `action_measure` ON action_measure.id = ach_actions.mesure_id WHERE `ach_area_id` = :id",['id' => $id]);
        $data['measures'] = $this->db->getRows("SELECT * FROM `action_measure`");

        if(!empty($data['actions'])) {
            foreach ($data['actions'] as $act) {
                $chats_in[] = $act['id'];
            }
            $chats_in = join(',', $chats_in);
            // Вот здесь нужна проверка, есть ли charts и дальше во view в выводе тоже проверка на поустоту
            $data['charts'] = $this->db->getRows("SELECT action_id, `date`, quantity FROM `charts` WHERE action_id IN ($chats_in)");
        }

        return $data;

    }

    public function add_action($id, $name, $measure){
        $has_name = $this->db->getRow("SELECT COUNT(*) as `count` FROM `ach_actions` WHERE `ach_area_id` = :id && `name` = :name", ['id'=> $id, 'name' => $name]);
        if($has_name['count'] == 0) {
            $this->db->run("INSERT INTO `ach_actions` (`ach_area_id`, `name`, `mesure_id`) VALUES(:id, :name, :measure)", ['id' => $id, 'name' => $name, 'measure' => $measure]);
            $last_insert_id = $this->db->lastInsertId();
            $this->db->run("INSERT INTO `charts` (`action_id`, `date`, `quantity`) VALUES($last_insert_id, NOW(), 0)");
            //$id = $this->db->lastInsertId();
            return $this->get_achievement($id);
        }else{
            return false;
        }
    }

    public function delete_action($id){

        $this->db->run("DELETE FROM `ach_actions` WHERE `id`=:id",['id'=>$id]);
    }

    public function edit_action($id, $name, $measure){
        $this->db->run("UPDATE `ach_actions` SET name=:name, mesure_id=:measure WHERE id=:id",['name'=>$name, 'measure'=>$measure, 'id'=>$id]);
    }

    public function get_area_id_by_action_id($id){
        return $this->db->getRow("SELECT `ach_area_id` FROM  `ach_actions` WHERE `id`=:id",['id'=>$id]);
    }


}