<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Expressions_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Gets the newest expressions.
     * @param unknown_type $num
     * @param unknown_type $offset
     */
    function getNewExpressions($num, $offset) {
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
        $sql .= "WHERE definitions.status ='A' ";
        $sql .= "ORDER BY definitions.create_date DESC ";
        $sql .= "LIMIT " . (is_numeric($offset) ? $offset : 0) . ", " . $num;
        $query = $this->db->query($sql);
        $expressions = $query->result();
        foreach($expressions as $expression) {
            $expression->tags = explode(',',$expression->tags);
        }
        return $expressions;
    }
    
    /**
     * Gets the newest expressions.
     * @param number $num
     * @param number $offset
     */
    function getRandomExpressions($num, $offset) {
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
        $sql .= "WHERE definitions.status ='A' ";
        $sql .= "ORDER BY RAND() ";
        $sql .= "LIMIT " . (is_numeric($offset) ? $offset : 0) . ", " . $num;
        $query = $this->db->query($sql);
        $expressions = $query->result();
        foreach($expressions as $expression) {
            $expression->tags = explode(',',$expression->tags);
        }
        return $expressions;
    }

    /**
     * Retrieves the top ten expressions.
     * @return unknown
     */
    function getTopTenExpressions($num, $offset) {
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
        $sql .= "WHERE definitions.status ='A' "; 
        $sql .= "ORDER BY (likes-dislikes) DESC, definitions.create_date DESC ";
        $sql .= "LIMIT " . (is_numeric($offset) ? $offset : 0) . ", " . $num;
        $query = $this->db->query($sql);
        $expressions = $query->result();
        foreach($expressions as $expression) {
            $expression->tags = explode(',',$expression->tags);
        }
        return $expressions;
    }
    
    /**
     * Counts the expressions in the database.
     * @return integer
     */
    function countExpressions() {
        $sql = "";
        $sql .= "SELECT count(*) AS total ";
        $sql .= "FROM   expressions ";
        $sql .= "       JOIN definitions ";
        $sql .= "         ON expressions.id = definitions.expression_id ";
        $sql .= "WHERE definitions.status ='A' ";
        $query = $this->db->query($sql);
        return $query->row()->total;
    }

    function getByDefinitionId($definitionId) {
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
        $sql .= "       definitions.tags as tags_list, ";
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
        $sql .= "WHERE definitions.id = '".$definitionId."' " ;
        $sql .= "AND definitions.status ='A' "; 
        $query = $this->db->query($sql);
        $expression = $query->row();
        if(isset($expression) && !is_null($expression) && $expression) {
            $expression->tags = explode(',',$expression->tags);
            $videos = array();
            $found_videos = $this->db->query("SELECT media.id, media.reason, media.url FROM media WHERE content_type='video/youtube' AND status = 'A' AND media.definition_id=".$expression->definition_id."")->result();
            foreach($found_videos as $found) {
                $videos[] = $found;
            }
            $expression->videos = $videos;
        }
        return $expression;
    }

    function getExpressionOnlyByText($text)	{
        $this->db->select(array('expressions.id', 'expressions.text', 'expressions.letter'));
        $this->db->where('expressions.text', $text);
        return $this->db->get('expressions');
    }
    
    function getByText($expression, $num, $offset) {
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
        $query = $this->db->query($sql);
        $expressions = $query->result();
        foreach($expressions as $expression) {
            $expression->tags = explode(',',$expression->tags);
            $videos = array();
            $found_videos = $this->db->query("SELECT media.id, media.reason, media.url FROM media WHERE content_type='video/youtube' AND status = 'A' AND media.definition_id=".$expression->definition_id."")->result();
            foreach($found_videos as $found) {
                $videos[] = $found;
            }
            $expression->videos = $videos;
        }
        return $expressions;
    }

    function countByText($expression) {
        $sql = "";
        $sql .= "SELECT count(*) AS total ";
        $sql .= "FROM   expressions ";
        $sql .= "       JOIN definitions ";
        $sql .= "         ON expressions.id = definitions.expression_id ";
        $sql .= "WHERE LOWER(expressions.text) = LOWER('".$expression."') " ;
        $sql .= "AND definitions.status = 'A' ";
        $expressions = array();
        $query = $this->db->query($sql)->row();
        return $query->total;
    }

    function getByLetter($letter, $num, $offset) {
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
        $sql .= "WHERE definitions.status = 'A' ";
        $sql .= "AND expressions.letter = '".strtoupper($letter)."' " ;
        $sql .= "ORDER BY CONVERT(expressions.text USING utf8) ASC, (likes-dislikes) DESC " ;
        $sql .= "LIMIT " . (is_numeric($offset) ? $offset : 0) . ", " . $num;
        $query = $this->db->query($sql);
        $expressions = $query->result();
        foreach($expressions as $expression) {
            $expression->tags = explode(',',$expression->tags);
        }
        return $expressions;
    }

    function countByLetter($letter) {
        $sql = "";
        $sql .= "SELECT count(*) AS total, ";
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
        $sql .= "WHERE expressions.letter = '".strtoupper($letter)."' " ;
        $sql .= "AND definitions.status = 'A' ";
        $query = $this->db->query($sql)->row();
        return $query->total;
    }
    
    function getOldestPending() {
        $sql = "";
        $sql .= "SELECT expressions.id, ";
        $sql .= "       expressions.text, ";
        $sql .= "       expressions.letter, ";
        $sql .= "       definitions.create_user, ";
        $sql .= "       definitions.create_date, ";
        $sql .= "       definitions.description, ";
        $sql .= "       definitions.example, ";
        $sql .= "       definitions.tags, ";
        $sql .= "       definitions.id                   AS definition_id ";
        $sql .= "FROM   expressions ";
        $sql .= "       JOIN definitions ";
        $sql .= "         ON expressions.id = definitions.expression_id ";
        $sql .= "WHERE definitions.status = 'P' " ;
        $sql .= "ORDER BY definitions.create_date ASC ";
        $sql .= "LIMIT 0, 1";
                $query = $this->db->query($sql);
        $expressions = $query->result();
        foreach($expressions as $expression) {
            $expression->tags = explode(',',$expression->tags);
        }
        return $expressions;
    }
    
    function getRandomPending() {
        $sql = "";
        $sql .= "SELECT expressions.id, ";
        $sql .= "       expressions.text, ";
        $sql .= "       expressions.letter, ";
        $sql .= "       definitions.tags, ";
        $sql .= "       definitions.create_user, ";
        $sql .= "       definitions.create_date, ";
        $sql .= "       definitions.description, ";
        $sql .= "       definitions.example, ";
        $sql .= "       definitions.tags, ";
        $sql .= "       definitions.id                   AS definition_id ";
        $sql .= "FROM   expressions ";
        $sql .= "       JOIN definitions ";
        $sql .= "         ON expressions.id = definitions.expression_id ";
        $sql .= "WHERE definitions.status = 'P' " ;
        $sql .= "ORDER BY RAND() ";
        $sql .= "LIMIT 0, 1";
        $query = $this->db->query($sql);
        $expression = $query->row();
        return $expression;
    }
    
    function getPending($num, $offset) {
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
        $sql .= "       definitions.id                   AS definition_id ";
        $sql .= "FROM   expressions ";
        $sql .= "       JOIN definitions ";
        $sql .= "         ON expressions.id = definitions.expression_id ";
        $sql .= "WHERE definitions.status = 'P' " ;
        $sql .= "ORDER BY definitions.create_date DESC ";
        $sql .= "LIMIT " . (is_numeric($offset) ? $offset : 0) . ", " . $num;
        $query = $this->db->query($sql);
        $expressions = $query->result();
        foreach($expressions as $expression) {
            $expression->tags = explode(',',$expression->tags);
        }
        return $expressions;
    }
    
    function countPending() {
        $sql = "";
        $sql .= "SELECT COUNT(*) as total ";
        $sql .= "FROM   expressions ";
        $sql .= "       JOIN definitions ";
        $sql .= "         ON expressions.id = definitions.expression_id ";
        $sql .= "WHERE definitions.status = 'P' " ;
        $query = $this->db->query($sql)->row();
        return $query->total;
    }
    
    function getRandomPendingMedia() {
        $sql = "";
        $sql .= "SELECT DISTINCT(expressions.id), ";
        $sql .= "       expressions.text, ";
        $sql .= "       expressions.letter, ";
        $sql .= "       definitions.create_user, ";
        $sql .= "       definitions.create_date, ";
        $sql .= "       definitions.description, ";
        $sql .= "       definitions.example, ";
        $sql .= "       definitions.tags, ";
        $sql .= "       definitions.id   AS definition_id, ";
        $sql .= "       media.id   AS media_id, ";
        $sql .= "       media.url, ";
        $sql .= "       media.reason ";
        $sql .= "FROM   expressions ";
        $sql .= "       JOIN definitions ";
        $sql .= "         ON expressions.id = definitions.expression_id ";
        $sql .= "       JOIN media ";
        $sql .= "         ON media.definition_id = definitions.id ";
        $sql .= "WHERE definitions.status = 'A' " ;
        $sql .= "AND media.status = 'P' " ;
        $sql .= "ORDER BY RAND() ";
        $sql .= "LIMIT 0, 1";
        $query = $this->db->query($sql);
        $expression = $query->row();
        if(isset($expression) && $expression) {
            $videos = array();
            $found_videos = $this->db->query("SELECT media.id, media.reason, media.url FROM media WHERE content_type='video/youtube' AND media.status ='A' AND media.definition_id=".$expression->definition_id."")->result();
            foreach($found_videos as $found) {
                $videos[] = $found;
            }
            $expression->videos = $videos;
        }
        return $expression;
    }

    function create($data) {
        $this->db->set('text', $data['text']);
        $this->db->set('letter', strtoupper($data['letter']));
        $this->db->set('create_user', $data['create_user']);
        $this->db->set('update_user', '');
        $time = date('Y-m-d H:i:s', time());
        $this->db->set('create_date', $time);
        $this->db->set('update_date', $time);
        $this->db->insert('expressions');
        return $this->db->insert_id();
    }

    function update($data) {
        $this->db->where('id', $data['id']);
        $this->db->set('text', $data['text']);
        $this->db->set('letter', $this->_get_expression_letter($data['text']));
        $this->db->set('update_user', $data['update_user']);
        $time = date('Y-m-d H:i:s', time());
        $this->db->set('update_date', $time);
        $this->db->update('expressions');
        return $this->db->affected_rows();
    }
    
    /**
     * Gets expression letter.
     * @param unknown_type $text
     * @return Ambigous <string, unknown>
     */
    function _get_expression_letter($text) {
        $letter = $text[0];
        if(is_numeric($letter)) {
            $letter = '0';
        }
        return $letter;
    }

    function delete($expressionId) {
        $this->db->where('id', $expressionId);
        $this->db->delete('expressions');
        return $this->db->affected_rows();
    }

    function approve_media($data) {
        $this->db->set('status', 'A');
        $this->db->set('update_user', $data['update_user']);
        $this->db->where('id', $data['media_id']);
        $this->db->where('definition_id', $data['definition_id']);
        $this->db->update('media');
    }
    
    function approve($id, $data) {
        $this->db->trans_start();
        
        $this->db->query("UPDATE expressions SET text = '".$data['expression']."' WHERE id = ".$data['expression_id']."");
        
        $this->db->set('status', 'A');
        $this->db->set('description', $data['description']);
        $this->db->set('example', $data['example']);
        $this->db->set('tags', $data['tags']);
        $this->db->where('id', $id);
        $this->db->update('definitions');
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    function hasDefinitions($id) {
        $this->db->select('expressions.id');
        $this->db->join('definitions', 'expressions.id = definitions.expression_id'); 
        $this->db->where('expressions.id', $id);
        return $this->db->get('expressions')->num_rows() > 0;
    }
    
    public function get_search_results($ids = array()) {
    	if (empty($ids))
    		return array();
    	$query = 'SELECT expressions.id, expressions.text, definitions.description, definitions.example, definitions.create_date, ' . 
    				'expressions.letter, definitions.create_user, definitions.id AS definition_id, definitions.tags, ' . 
    				'(SELECT COUNT(ratings.rating) FROM ratings WHERE ratings.definition_id = definitions.id AND ratings.rating = 1) AS likes, ' .
    				'(SELECT COUNT(ratings.rating) FROM ratings WHERE ratings.definition_id = definitions.id AND ratings.rating = -1) AS dislikes ' .
    				'FROM expressions JOIN definitions ON expressions.id = definitions.expression_id WHERE definitions.status = \'A\' ' .
    				'AND definitions.id IN (';
    	$i = 1;
    	$ids_string = '';
    	foreach ($ids as $id) {
    		$ids_string = $ids_string . $id;
    		if ($i != count($ids)) 
    			$ids_string = $ids_string . ', ';
    		$i++;
    	}
    	$query = $query . $ids_string . ')';
    	$q = $this->db->query($query);
    	$expressions = $q->result();
    	foreach($expressions as $expression) {
    		$expression->tags = explode(',',$expression->tags);
    	}
    	return $expressions;
    }
}
