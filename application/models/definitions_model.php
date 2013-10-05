<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Definitions_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function readAll() {
		$expressions = array();
		$query = $this->db->get('definitions');
		$this->db->order_by("description", "asc");
		return $query;
	}
	
	function readWithPagination($num, $offset) {
	    $sql = "";
	    $sql .= "SELECT expressions.id, ";
	    $sql .= "       expressions.text, ";
	    $sql .= "       expressions.letter, ";
	    $sql .= "       definitions.create_user, ";
	    $sql .= "       definitions.create_user, ";
	    $sql .= "       definitions.create_date, ";
	    $sql .= "       definitions.description, ";
	    $sql .= "       definitions.example, ";
	    $sql .= "       definitions.tags, ";
	    $sql .= "       definitions.id                   AS definition_id, ";
	    $sql .= "       (SELECT Count(ratings.rating) ";
	    $sql .= "        FROM   ratings ";
	    $sql .= "        WHERE  ratings.definition_id = definitions.id ";
	    $sql .= "               AND ratings.rating = 1)  AS likes, ";
	    $sql .= "       (SELECT Count(ratings.rating) ";
	    $sql .= "        FROM   ratings ";
	    $sql .= "        WHERE  ratings.definition_id = definitions.id ";
	    $sql .= "               AND ratings.rating = -1) AS dislikes ";
	    $sql .= "FROM   expressions ";
	    $sql .= "       JOIN definitions ";
	    $sql .= "         ON expressions.id = definitions.expression_id ";
	    $sql .= "WHERE LOWER(expressions.text) = LOWER('".$expression."') " ;
	    $sql .= "AND definitions.status = 'A' ";
	    $sql .= "ORDER BY (likes-dislikes) DESC ";
	    $sql .= "LIMIT " . (is_numeric($offset) ? $offset : 0) . ", " . $num;
	}
	
	function create($data) {
		$this->db->set('expression_id', $data['expression_id']);
		$this->db->set('description', $data['description']);
		$this->db->set('example', $data['example']);
		$this->db->set('tags', $data['tags']);
		$this->db->set('email', $data['email']);
		$this->db->set('status', $data['status']);
		$this->db->set('create_user', $data['create_user']);
		$this->db->set('create_user_ip', $data['create_user_ip']);
		$this->db->set('update_user', '');
		$time = date('Y-m-d H:i:s', time());
		$this->db->set('create_date', $time);
		$this->db->set('update_date', $time);
		$this->db->insert('definitions');
		return $this->db->insert_id();
	}
	
	function update($data) {
		$this->db->where('id', $data['id']);
		$this->db->set('description', $data['description']);
		$this->db->set('example', $data['example']);
		$this->db->set('tags', $data['tags']);
		$this->db->set('update_user', $data['update_user']);
		$time = date('Y-m-d H:i:s', time());
		$this->db->set('update_date', $time);
		$this->db->update('definitions');
		return $this->db->affected_rows();
	}
	
	function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete('definitions');
		return $this->db->affected_rows();
	}
	
	function delete2($id, $expression_id) {
	    $this->db->trans_start();
	    
	    $this->db->query("DELETE FROM definitions WHERE id = $id");
	    
	    $sql = "SELECT expressions.id FROM expressions JOIN definitions ON expressions.id = definitions.expression_id WHERE expressions.id=$expression_id";
	    if(($this->db->query($sql)->num_rows()) <= 0) {
	        $this->db->query("DELETE FROM expressions WHERE id = $expression_id");
	    }
	    
	    if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return FALSE;
	    } else {
	        $this->db->trans_commit();
	        return TRUE;
	    }
	}
	
	/**
	 * Gets the email of a definition.
	 * @param unknown_type $definition_id
	 */
	function getEmail($definition_id) {
	    $this->db->select('definitions.email');
	    $this->db->where('id', $definition_id);
	    $query = $this->db->get('definitions')->row();
	    return $query->email;
	}
}
