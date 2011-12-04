<?php
/**
 * User: alex
 * Date: 11/30/11
 * Time: 9:17 PM
 *
 */

class Page extends Model {
	public $id;
	public $name;
	static public $table = 'pages';

	static public function findByDirectoryName($directoryName) {
		$row = DbConnection::getInstance()->selectRow('SELECT * FROM ?_'.self::$table.' WHERE `name` = ?', $directoryName);
		if ($row) {
		    $page = new Page();
			$page->id = $row['id'];
			$page->name = $row['name'];
			return $page;
		}
	}

	public function save() {
		$attributes = array('name' => $this->name);
		if ($this->id) {
			// update
			$this->db->query('UPDATE ?_'.self::$table.' SET ?a WHERE id = ?d', $attributes, $this->id);
		} else {
			// insert
			$this->id = $this->db->query('INSERT INTO ?_'.self::$table.' SET ?a ', $attributes);
		}
	}

	public function findVersionByFileName($fileName) {
		return PageVersion::findByPageAndFileName($this->id, $fileName);
	}

	static public function getHomePageData() {
		return self::_getHomePageData();
	}

	static private function _getHomePageData($pageName = null) {
		if ($pageName) {
		    $pages = DbConnection::getInstance()->select('SELECT p.id page_id, p.name page_name, pv.id page_version_id, pv.name page_version_name FROM ?_'.self::$table.' p LEFT JOIN ?_'.PageVersion::$table.' pv ON pv.page_id = p.id WHERE p.name = ? ORDER BY p.name, pv.name', $pageName);
		} else {
			$pages = DbConnection::getInstance()->select('SELECT p.id page_id, p.name page_name, pv.id page_version_id, pv.name page_version_name FROM ?_'.self::$table.' p LEFT JOIN ?_'.PageVersion::$table.' pv ON pv.page_id = p.id ORDER BY p.name, pv.name');
		}
		$itemsPerRow = 6;
		$rows = array();
		$row = array();
		$rowItem = array();
		$pageNumber = 0;
		foreach ($pages as $index => $page) {
			// next row
			if (count($row) == $itemsPerRow) {
			    $rows[] = $row;
				$row = array();
			}

			// next page
			if (!$rowItem || $rowItem['id'] != $page['page_id']) {
				if ($rowItem) {
					$row[] = $rowItem;
				}
				if ($pageNumber == 0) {
					$title = 'cover';
					$pageNumber++;
				} else if ($pageNumber == 1) {
					$title = 'cover-1';
					$pageNumber++;
				} else {
					$title = $pageNumber . '-' . ($pageNumber+1);
					$pageNumber += 2;
				}
				$rowItem = array(
					'id' => $page['page_id'],
					'title' => $title,
					'name' => $page['page_name'],
					'versions' => array()
				);
			}

			// push revision
			if ($page['page_version_id']) {
				$rowItem['versions'][] = array(
					'name' => $page['page_version_name']
				);
			}
		}

		if ($rowItem) {
			$rowItem['title'] = ($pageNumber - 2) . '-cover';
		    $row[] = $rowItem;
		}

		if ($row) {
		    $rows[] = $row;
		}

		return $rows;
	}

	static public function getPageData($pageName) {
		$pages = Page::_getHomePageData($pageName);
		if (isset($pages[0][0])) {
			$page = $pages[0][0];
		    return $page;
		}
	}

	static public function pageNameByNumber($pageNumber) {
		$pageName = round(($pageNumber + 4)/2);
		return str_pad($pageName, 3, '0', STR_PAD_LEFT);
	}

	static public function getPageDataByTitle($title) {
		$matches = array();
		if ($title == 'cover') {
		    $pageName = '001';
		} else if ($title == 'cover-1') {
			$pageName = '002';
		} else if (
			preg_match('/^(?P<pageNumber>\d{1,3})\-cover$/i', $title, $matches)
			||
			preg_match('/^(?P<pageNumber>\d{1,3})\-(?P<secondPageNumber>\d{1,3})$/i', $title, $matches
		)) {
			$pageName = self::pageNameByNumber($matches['pageNumber']);
		}
		if (isset($pageName)) {
			$page = self::getPageData($pageName);
			if ($page) {
			    $page['title'] = $title;
				return $page;
			}
		}
	}
}
