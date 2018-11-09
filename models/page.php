<?php

class Page extends Model{
	public function getCategories(){
		$sql = "select * from categories";

		return $this->db->query($sql);
	}

	public function getPagination($cat){
		$sql = "select COUNT(*) as c from pages where category = {$cat}";

		$pg = $this->db->query($sql)[0]['c'] / Config::get('pages_in_pagination');

		return round($pg);
	}

	public function getList($cat = false, $only_published = false, $orderby = 'asc', $start = false, $offset = false){
		$sql = "select * from pages where 1";

		if ( $cat ) {
			$sql .= " and category = {$cat}";
		}
		
		if ( $only_published ){
			$sql .= " and is_published = 1";
		}

		$sql .= " order by publish_date {$orderby}";

		if ( $start && $offset ) {
			$sql .= " limit {$start}, {$offset}";
		}
	
		return $this->db->query($sql);
	}

	public function getByAlias($alias){
		$alias = $this->db->escape($alias);
		$sql = "select * from pages where alias = '{$alias}' limit 1";
		$result = $this->db->query($sql);
		return isset($result[0]) ? $result[0] : null;
	}

	public function getById($id){
		$id = (int)$id;
		$sql = "select * from pages where id = '{$id}' limit 1";
		$result = $this->db->query($sql);
		return isset($result[0]) ? $result[0] : null;
	}

	public function save($data, $id = null){
		if ( !isset($data['alias']) || !isset($data['title']) || !isset($data['content']) ){
			return false;
		}

		$id = (int)$id;
		$alias = $this->db->escape($data['alias']);
		$title = $this->db->escape($data['title']);
		$content = $this->db->escape($data['content']);
		$is_published = isset($data['is_published']) ? 1 : 0;
		$category = $this->db->escape($data['category']);

		$image_selected = false;

		if ( $_FILES['inputimg']['name'] && $_FILES['inputimg']['size'] ) {
			$tmp_name = explode('.', $_FILES['inputimg']['name']);
			$_FILES['inputimg']['name'] = md5(time().$_FILES['inputimg']['name']).'.'.end($tmp_name);
			$image_selected = true;
		}

		if ( !$id ){ // Add new record
			$sql = "
				insert into pages
				set alias = '{$alias}',
					title = '{$title}',
					content = '{$content}',
					is_published = {$is_published},
					image = '{$_FILES['inputimg']['name']}',
					category = {$category},
					publish_date = NOW()
			";
		} else { // Update existing record

			$sql = "select image from pages where id = {$id}";
			$result = $this->db->query($sql);

echo '<pre>'; print_r(IMGDIR); echo '</pre>';


echo '<pre>'; print_r(IMGDIR.$_FILES['inputimg']['name']); echo '</pre>';

			//if ( $image_selected && file_exists(IMGDIR.$result[0]['image']) ) {
			//	unlink(IMGDIR.$result[0]['image']);
				move_uploaded_file($_FILES['inputimg']['tmp_name'], IMGDIR.$_FILES['inputimg']['name'] );
			//}

			$sql = "
				update pages
				set alias = '{$alias}',
					title = '{$title}',
					content = '{$content}',
					is_published = {$is_published},
					image = '{$_FILES['inputimg']['name']}',
					category = {$category},
					publish_date = NOW()
				where id = {$id}
			";
		}

		return $this->db->query($sql);
	}

	public function delete($id){
		$id = (int)$id;
		$sql = "delete from pages where id = {$id}";
		return $this->db->query($sql);
	}


	public function getAboutContent(){
		$sql = "select * from pages where alias = 'about' limit 1";
		return $this->db->query($sql);
	}

}