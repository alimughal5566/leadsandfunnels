<?php
namespace App\Repositories;
use App\Services\DbService;

class PixelRepository {
	private $db;
	private $sessionDb;

    public function __construct(DbService $service){
        $this->db = $service;
    }

    /* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
                    CODE BELOW TO THIS SEPERATION NEEDS TO VERIFY
     ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */

	public function addPixel( $post ){
		$query = 'INSERT INTO leadpops_pixels ('. $this->column_list($post). ') VALUES '.$this->insert_values($post);
	/*	echo "<br>";
		echo "<br>";
        echo $query;*/
        $this->db->query($query);
        return $this->db->lastInsertId();
//		dd($query);
	}

	public function removePixel( $client_id, $group_identifier, $domains_ids){
		$query = "DELETE FROM leadpops_pixels WHERE group_identifier = '$group_identifier'";
		$query .= " AND domain_id NOT IN ($domains_ids) AND client_id = $client_id";
		return $this->db->query($query);
	}

	public function updatePixel( $post, $conditions = array()){
		$query = 'UPDATE leadpops_pixels SET ' . $this->update_columns($post) . ' WHERE ' . $this->where_list($conditions);
		return $this->db->query($query);
	}

	public function getPixels( $where = array() ){
		$query = "SELECT * FROM leadpops_pixels WHERE pixel_type > 0 AND ".$this->where_list($where) . " ORDER BY id ASC";
		return $this->db->fetchAll($query);
	}

	public function addUpdatePixel( $post, $group_identifier ){
		$pixel = $this->getPixels( array("group_identifier"=>$group_identifier, "domain_id" => $post["domain_id"]) );
		if($pixel){
			$updateInfo = array( "pixel_name"=>$post["pixel_name"],
								 "pixel_code"=>$post["pixel_code"],
								 "pixel_type"=>$post["pixel_type"],
								 "pixel_placement"=>$post["pixel_placement"],
								 "pixel_action"=>@$post["pixel_action"],
								 "pixel_other"=>@$post["pixel_other"] );
			$this->updatePixel( $updateInfo, array("id"=>$pixel[0]['id']) );
		} else {
			unset($post['lpkey_pixels']);
			$post['group_identifier'] = $group_identifier;
			$this->addPixel( $post );
		}
	}

	public function deletePixels( $id, $client_id = '', $is_group_identifier = false ){
		if($is_group_identifier){
			$query = "DELETE FROM leadpops_pixels WHERE group_identifier = '$id'";
		} else {
			$query = "DELETE FROM leadpops_pixels WHERE id = $id";
		}

		if($client_id){
			$query .= " AND client_id = $client_id";
		}
		return $this->db->query($query);
	}

	private function column_list($data=null) {
		if(is_array($data)) {
			return implode(', ', array_keys($data) );
		} else {
			return null;
		}
	}

	private function insert_values($data=array()) {
		$row = '';
		foreach($data as $value) {
            if(is_array($value)){
                $value = implode(',',$value);
			}
			$row .= "'". addslashes($value) ."', ";
		}
		return '('. rtrim($row, ', '). ')';
	}

	private function update_columns($data=array()) {
		$output = array();
		if(is_array($data)) {
			foreach ($data as $field => $value) {
                if(is_array($value)){
                    $value = implode(',',$value);
                }
				$output[] = $field . " = '". addslashes($value). "'";
			}
		}
		return implode(', ', $output);
	}

	private function where_list($where = array()){
		$output = array();
		if(is_array($where)) {
			foreach ($where as $field => $value) {
				$output[] = $field . " = '". ($value). "'";
			}
		}
		return implode(' AND ', $output);
	}

}

?>
