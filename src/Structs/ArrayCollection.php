<?php
namespace Evan\Structs;

use Exception;

/**
 * Uses native PHP arrays to implement the Collection interface.
 */
final class ArrayCollection implements Collection {
	/** @var array */
	private $items;
	
	/**
	 * @param array  $items The set of items in the collection
	 */
	public function __construct(array $items = array()) {
		$this->items = $items;
	}
	
	/** @override */
	public function count() {
		return count($this->items);
	}
	
	/** @override */
	public function current() {
		return current($this->items);
	}
	
	/** @override */
	public function filter(callable $filter) {
		$results = array();
		
		foreach ($this->items as $item) {
			if ($filter($item)) {
				$results[] = $item;
			}
		}
		
		return new ArrayCollection($results);
	}
	
	/** @override */
	public function has($item) {
		return in_array($item, $this->items, true);
	}

	/** @override */
	public function key() {
		return key($this->items);
	}
	
	/** @override */
	public function map(callable $mapper) {
		$results = array();
		foreach ($this->items as $item) {
			$results[] = $mapper($item);
		}
		return new ArrayCollection($results);
	}
	
	/** @override */
	public function next() {
		return next($this->items);
	}
	
	/** @override */
	public function rewind() {
		reset($this->items);
	}
	
	/** @override */
	public function valid() {
		return key($this->items) !== NULL;
	}
}