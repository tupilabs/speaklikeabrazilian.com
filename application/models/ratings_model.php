<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model for ratings.
 * @since 0.1
 */
class Ratings_model extends CI_Model {
	/**
	 * Default constructor.
	 */
	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	/**
	 * Gets whether the user (by IP) has already voted up or not.
	 * @param unknown_type $definition_id
	 * @param unknown_type $ip
	 * @return boolean
	 */
	function hasUserVotedUp($definition_id, $ip) {
	    $this->db->where('ratings.definition_id', $definition_id);
	    $this->db->where('ratings.user_ip', $ip);
	    $this->db->where('ratings.rating', 1);
	    return $this->db->get('ratings')->num_rows() > 0;
	}
	/**
	 * Gets whether the user (by IP) has already voted down or not.
	 * @param unknown_type $definition_id
	 * @param unknown_type $ip
	 * @return boolean
	 */
	function hasUserVotedDown($definition_id, $ip) {
	    $this->db->where('ratings.definition_id', $definition_id);
	    $this->db->where('ratings.user_ip', $ip);
	    $this->db->where('ratings.rating', -1);
	    return $this->db->get('ratings')->num_rows() > 0;
	}
	/**
	 * Votes for a definition.
	 * @param unknown_type $definition_id
	 * @param unknown_type $ip
	 * @param unknown_type $rating
	 */
	function vote($definition_id, $ip, $rating) {
	    $sql = "INSERT INTO ratings(definition_id, user_ip, rating) VALUES('".$definition_id."', '".$ip."', '".$rating."') ON DUPLICATE KEY UPDATE rating='".$rating."'";
	    return $this->db->query($sql);
	}
	/**
	 * Auto vote for a definition approved.
	 * @param unknown_type $definition_id
	 */
	function vote2($definition_id) {
		$sql = "INSERT INTO ratings(definition_id, user_ip, rating) VALUES('".$definition_id."', (SELECT create_user_ip FROM definitions d WHERE d.id=".$definition_id."), '1') ON DUPLICATE KEY UPDATE rating='1'";
		return $this->db->query($sql);
	}
	/**
	 * Gets votes for a definition.
	 * @param integer $definition_id
	 * @return array mixed
	 */
	function getVotes($definition_id) {
	    $sql = "SELECT ratings.rating, count(*) AS total FROM ratings WHERE ratings.definition_id='".$definition_id."' GROUP BY ratings.rating";
	    $votes =  $this->db->query($sql)->result();
	    $likes = 0;
	    $dislikes = 0;
	    foreach($votes as $vote) {
	        if($vote->rating == -1) {
	            $dislikes += $vote->total;
	        } elseif ($vote->rating == 1) {
	            $likes += $vote->total;
	        }
	    }
	    return array('likes' => $likes, 'dislikes' => $dislikes);
	}
}
