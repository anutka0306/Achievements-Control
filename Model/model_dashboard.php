<?php


class Model_Dashboard extends Model
{
    public function get_data()
    {
        return $this->db->getRows("SELECT * FROM `ach_area` JOIN `area_status` ON status_id = ach_area.status WHERE `user_id` = :id", ['id'=>$this->UID]);
    }

    public function get_achievement($id){
        return $this->db->getRow("SELECT * FROM `ach_area` JOIN `area_status` ON status_id = ach_area.status WHERE `id` = :id", ['id' =>$id]);
    }

    public function create_achievement_area($user,$name, $description){
        $has_name = $this->db->getRow("SELECT COUNT(*) as `count` FROM `ach_area` WHERE `user_id` = :id && `name` = :name", ['id'=> $user, 'name' => $name]);
        if($has_name['count'] == 0) {
            $this->db->run("INSERT INTO `ach_area` (`user_id`, `name`, `description`) VALUES(:user, :name, :description)", ['user' => $user, 'name' => $name, 'description' => $description]);
            $id = $this->db->lastInsertId();
            return $this->get_achievement($id);
        }else{
            return false;
        }
    }

    public function delete_achievement_area($id){
        $this->db->run("DELETE FROM `ach_area` WHERE `id` = :id", ['id'=>$id]);
    }

    public function edit_achievement_area($id, $name, $description, $start_date, $user){
        $has_name = $this->db->getRow("SELECT COUNT(*) as `count` FROM `ach_area` WHERE `user_id` = :user && `name` = :name && `id` != :id", ['user'=> $user, 'name' => $name, 'id'=>$id]);
        if($has_name['count'] == 0) {
            $this->db->run("UPDATE `ach_area` SET name=:name, description=:description, start_date=:start_date WHERE id=:id", ['name' => $name, 'description' => $description, 'start_date' => $start_date, 'id' => $id]);
            return $this->get_achievement($id);
        }else{
            return false;
        }
    }

    public function complete_achievement_area($id){
        $this->db->run("UPDATE `ach_area` SET status=:status, end_date=CURRENT_DATE() WHERE id=:id", ['status' => 2, 'id' => $id]);
        return $this->get_achievement($id);
    }
}