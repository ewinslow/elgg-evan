<?php
namespace Evan\Storage;

class UsersQuery extends EntitiesQuery {
	private $search = '';

	/**
	 * Do not return banned users by default
	 */
	private $banned = false;
	
	/**
	 * Return admins and normal users by default
	 */
	private $admin = NULL;
	
	public function __construct(Db $db) {
		parent::__construct($db);
		
		$this->addJoin("users_entity u on e.guid = u.guid");
	}
	
	public function search($q) {
		$this->search = $q;
		return $this;
	}
	
	public function where($property, $value) {
		switch ($property) {
			case 'type':
				throw new Exception("Cannot customize the type of a users-only query!");
			case 'banned':
			case 'admin':
				$this->{$property} = $value;
				break;
			case 'validated':
				$this->validated = $value;
				$this->where('enabled', $value);
				break;
			default:
				return parent::where($property, $value);
		}
		
		return $this;
	}
	
	protected function getOptions() {
		$options = parent::getOptions();
		
		if ($this->banned === true) {
			$options['wheres'][] = "u.banned = 'yes'";
		} elseif ($this->banned === false) {
			$options['wheres'][] = "u.banned = 'no'";
		}
		
		if ($this->admin === true) {
			$options['wheres'][] = "u.admin = 'yes'";
		} elseif ($this->admin === false) {
			$options['wheres'][] = "u.admin = 'no'";
		}
		
		if ($this->search) {
			$q = sanitize_string($this->search);
			
			$where = "u.name LIKE \"%{$q}%\" OR u.username LIKE \"%{$q}%\"";
			if (\elgg_is_admin_logged_in()) {
				$where .= " u.email LIKE \"%{$q}%\"";
			}
			$options['wheres'][] = "($where)";
		}
		
		/*
		 * "Unvalidated" means metadata of validated is not set or not truthy.
		 * We can't use elgg_get_entities_from_metadata() because you can't say
		 * "where the entity has metadata set OR it's not equal to 1".
		 */
		if ($this->validated === false) {
			$validated_id = \get_metastring_id('validated');
			if ($validated_id === false) {
				$validated_id = \add_metastring('validated');
			}
			$one_id = \get_metastring_id('1');
			if ($one_id === false) {
				$one_id = \add_metastring('1');
			}
		
			$options['wheres'][] = "NOT EXISTS (
				SELECT 1 FROM {$this->getDB()->getPrefix()}metadata validated_md
				WHERE validated_md.entity_guid = e.guid
					AND validated_md.name_id = $validated_id
					AND validated_md.value_id = $one_id)";
		}
		
		return $options;
	}
}