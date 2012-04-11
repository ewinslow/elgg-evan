<?php

class EvanMenu {
	private $items = array();
	
	public function __construct(array $items = array()) {
		foreach ($items as $item) {
			if ($item instanceof ElggMenuItem) {
				$items[$item->getName()] = $item;
			}
		}
	}
	
	/**
	 * @param string $identifier
	 * @param array $options
	 * @return ElggMenuItem
	 */
	public function registerItem($identifier, array $options) {
		$options['name'] = $identifier;
		
		$item = ElggMenuItem::factory($options);
		$this->items[$identifier] = $item;
		return $item;
	}
	
	/**
	 * @param string $identifier
	 * @return ElggMenuItem The item that was unregistered.
	 */
	public function unregisterItem($identifier) {
		$item = $this->items[$identifier];
		unset($this->items[$identifier]);
		return $item;
	}
	
	/**
	 * @return array The list of items in this menu in no particular order.
	 */
	public function getItems() {
		return $this->items;
	}
	
	/**
	 * @param string $identifier
	 * @return ElggMenuItem
	 */
	public function getItem($identifier) {
		return $this->items[$identifier];
	}
}