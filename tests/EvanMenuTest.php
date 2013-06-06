<?php

class EvanMenuTest extends PHPUnit_Framework_TestCase {
    public function testGetItemsReturnsOriginalItems() {
		$items = array(
			new ElggMenuItem('name1', 'text1', 'url1'),
			new ElggMenuItem('name2', 'text2', 'url2'),
		);

		$menu = new EvanMenu($items);

		$i = 0;
		foreach ($menu->getItems() as $item) {
			$this->assertEquals($items[$i++], $item);
		}
	}

	public function testRegisterItem() {
		$menu = new EvanMenu();

		$item1 = $menu->registerItem('name1', array(
			'text' => 'text1',
			'href' => 'url1',
		));

		$this->assertEquals('url1', $item1->getHref());
		$this->assertEquals('name1', $item1->getName());
	
		$item1_gotten = $menu->getItem('name1');
		$this->assertEquals($item1, $item1_gotten);
	
		$item1_unregistered = $menu->unregisterItem('name1');
		$this->assertEquals($item1, $item1_unregistered);

		$this->assertEquals(0, count($menu->getItems()));
	}
}    
