<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	protected $table = '';
	protected $audit_fields = FALSE;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function all() {
		return $this->db->get($this->table)->result();
	}
	
	public function get_by_id($id) {
		$this->db->where('id', $id);
		return $this->db->get($this->table)->row();
	}
	
	public function create($entity) {
		$this->validate($entity);
		if ($this->audit_fields === TRUE) {
			if (!isset($entity->create_date)) 
				$entity->create_date = date("Y-m-d H:i:s");
			if (!isset($entity->create_user))
				$entity->create_user = $this->input->ip_address();
		}
		$this->db->insert($this->table, $entity);
		return $this->db->insert_id();
	}
	
	public function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete($this->table);
		return $this->db->affected_rows();
	}
	
	public function edit($entity) {
		$this->validate($entity);
		if (isset($entity->id)) {
			if ($this->audit_fields === TRUE) {
				if (!isset($entity->update_date))
					$entity->update_date = date("Y-m-d H:i:s");
				if (!isset($entity->update_user))
					$entity->update_user = $this->input->ip_address();
			}
			$this->db->where('id', $entity->id);
			$this->db->update($this->table, $entity);
			return $this->db->affected_rows();
		}
		return 0;
	}
	
	/**
	 * Validates the DAO's entity.
	 * @throws Exception if there is any invalid field
	 */
	public function validate($object) {
		// do nothing
	}
	
}
