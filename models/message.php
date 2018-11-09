<?php

class Message extends Model {

	public function save($data, $id = null){
		if ( !isset($data['name']) || !isset($data['email']) || !isset($data['phone']) || !isset($data['message']) ){
			return false;
		}

		$id = (int)$id;
		$name = $this->db->escape($data['name']);
		$email = $this->db->escape($data['email']);
		$phone = $this->db->escape($data['phone']);
		$message = $this->db->escape($data['message']);

	if ( !$id ){ // Add new record
		$sql = "
			insert into messages
			set name = '{$name}',
			email = '{$email}',
			phone = '{$phone}',
			message = '{$message}'
		";
	}/* else { // Update existing record
		$sql = "
		update messages
		set name = '{$name}',
		email = '{$email}',
		message = '{$message}'
		where id = {$id}
		";
	}*/

	return $this->db->query($sql);

	}

	public function getList(){
		$sql = "select * from messages where 1";
		return $this->db->query($sql);
	}

	public function delete($id){
		$id = (int)$id;
		$sql = "delete from messages where id = {$id}";
		return $this->db->query($sql);
	}
}