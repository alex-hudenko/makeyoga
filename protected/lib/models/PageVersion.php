<?php
/**
 * User: alex
 * Date: 11/30/11
 * Time: 9:17 PM
 *
 */

class PageVersion extends Model {
	public $id;
	public $page_id;
	public $name;

	static public $table = 'page_versions';

	static public function findByPageAndFileName($pageId, $fileName) {
		$row = DbConnection::getInstance()->selectRow('SELECT * FROM ?_'.self::$table.' WHERE page_id = ?d AND `name` = ?', $pageId, $fileName);
		if ($row) {
		    $pageVersion = new PageVersion();
			$pageVersion->id = $row['id'];
			$pageVersion->page_id = $row['page_id'];
			$pageVersion->name = $row['name'];
			return $pageVersion;
		}
	}

	public function save() {
		$attributes = array('name' => $this->name, 'page_id' => $this->page_id);
		if ($this->id) {
			$this->db->query('UPDATE ?_'.self::$table.' SET ?a WHERE id = ?d', $attributes, $this->id);
		} else {
			$this->id = $this->db->query('INSERT INTO ?_'.self::$table.' SET ?a', $attributes);
		}
	}


}
