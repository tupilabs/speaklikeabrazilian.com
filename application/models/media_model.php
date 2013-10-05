<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Media_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function create($data) {
        $data['status'] = 'P';
        $this->db->set('definition_id', $data['definition_id']);
        $this->db->set('url', $data['url']);
        $this->db->set('reason', $data['reason']);
        $this->db->set('status', $data['status']);
        $this->db->set('content_type', $data['content_type']);
        $time = date('Y-m-d H:i:s', time());
        $this->db->set('create_user', 'backend');
        $this->db->set('update_user', 'backend');
        $this->db->set('create_date', $time);
        $this->db->set('update_date', $time);
        //$this->db->insert('media');
        $insert_query = $this->db->insert_string('media', $data);
        $insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
        return $this->db->query($insert_query);
    }
    
    function delete($media_id) {
        $this->db->where('id', $media_id);
        $this->db->delete('media');
        return $this->db->affected_rows();
    }
}
