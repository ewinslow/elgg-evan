<?php
namespace Evan\Storage;


class EntitiesQuery implements Query {
	
	private $db = NULL;

	/**
	 * entity type (type IN ('type1', 'type2')) Joined with subtypes by AND. See below
	 */
	public $types = NULL;
	
	public $subtypes = NULL;
	
	public $type_subtype_pairs = NULL;
	
	public $guids = NULL;
	
	public $owner_guids = NULL;
	
	public $container_guids = NULL;
	
	public $site_guids = NULL;
	
	public $order_by = 'time_created desc';
	
	public $reverse_order_by = false;
	
	public $created_time_lower = NULL;
	
	public $created_time_upper = NULL;
	
	public $modified_time_lower = NULL;
	
	public $modified_time_upper = NULL;
	
	private $enabled = true;
	
	private $wheres = array();
	
	private $joins = array();
	
	public function __construct(MysqlDb $db) {
		$this->db = $db;
	}
	
	protected function getDB() {
		return $this->db;
	}
	
	public function where($property, $value) {
		switch ($property) {
			case 'container_guid':
			case 'guid':
			case 'owner_guid':
			case 'site_guid':
			case 'subtype':
			case 'type':
				if (!is_array($value)) {
					$value = array($value);
				}
				
				$this->{"{$property}s"} = $value;
				break;
			case 'enabled':
				$this->enabled = $value;
				break;
			default:
				throw new Exception("Field not recognized");
				break;
		}
		
		return $this;
	}
	
	public function addWhere($where) {
		$this->wheres[] = $where;
		
		return $this;
	}
	
	public function addWheres(array $wheres = array()) {
		foreach ($wheres as $where) {
			$this->addWhere($where);
		}
		
		return $this;
	}
	
	public function addJoin($join) {
		$this->joins[] = "JOIN {$this->getDB()->getPrefix()}$join";
		
		return $this;
	}
	
	protected function getOptions() {
		$options = array(
			'types' => $this->types,
			'subtypes' => $this->subtypes,
			'type_subtype_pairs' => $this->type_subtype_pairs,
			'guids' => $this->guids,
			'owner_guids' => $this->owner_guids,
			'container_guids' => $this->container_guids,
			'site_guids' => $this->site_guids,
			'order_by' => $this->order_by,
			'reverse_order_by' => $this->reverse_order_by,
			'created_time_lower' => $this->created_time_lower,
			'created_time_upper' => $this->created_time_upper,
			'modified_time_lower' => $this->modified_time_lower,
			'modified_time_upper' => $this->modified_time_upper,
			'wheres' => $this->wheres,
			'joins' => $this->joins,
		);
		
		// TODO(evan): Should be done this way in elgg_get_entities instead
		// of with the access_show_hidden_entities() hack.
		/*
		if ($this->enabled === true) {
			$options['wheres'][] = "e.enabled = 'yes'";
		} else if ($this->enabled === false) {
			$options['wheres'][] = "e.enabled = 'no'";
		}
		*/
		
		return $options;
	}
	
	public function getCount() {
        return $this->getTotalItems();
    }
	
    public function getTotalItems() {
    	return $this->getEntities_(array(
			'count' => TRUE,
		));
    }
    
	private function getEntities_(array $options = array()) {
		$options = array_merge($this->getOptions(), $options);
		
		if ($this->enabled !== true) {
			$hidden_entities = \access_get_show_hidden_status();
			\access_show_hidden_entities(TRUE);
		}
		
		$result = elgg_get_entities($options);

		if ($this->enabled !== true) {
			\access_show_hidden_entities($hidden_entities);
		}

		return $result;
	}
	
	public function getItems($limit = NULL, $offset = NULL) {
		return $this->getEntities_(array(
			'limit' => $limit,
			'offset' => $offset,
		));
	}
	
	/**
	 * Retrieve the nth item in the result set of the query
	 */
	public function getItem($offset = 0) {
		$query = clone $this;
		$items = $query->getItems(1, $offset);
		return $items[0];
	}
}