<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Respect\Validation\Validator as v;

/**
 * DAO for subscribers.
 * @since 0.2
 */
class Subscribers_dao extends MY_Model {
	/**
	 * Default constructor.
	 */
	function __construct() {
		parent::__construct();
		$this->table = 'subscribers';
		$this->audit_fields = TRUE;
	}
	
	/**
	 * @param stdClass $object
	 */
	public function validate($object) {
		if (!v::notEmpty()->string()->length(1, 255, TRUE /*inclusive*/)->email()->validate($object->email))
			throw new InvalidArgumentException('Invalid subscriber e-mail');
	}
	
	/**
	 * Get subscribers by e-mail.
	 * @param string $email
	 * @return array|stdClass
	 */
	public function get_by_email($email) {
		$this->db->where('email', $email);
		return $this->db->get($this->table)->result();
	}

}
