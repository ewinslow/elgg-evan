<?php
namespace Evan;

use ElggMenuItem as MenuItem;

class MenuTest extends \PHPUnit_Framework_TestCase {
	public function setUp() {
    	if (!class_exists('ElggMenuItem')) {
    		$this->markTestSkipped("Need Elgg ~1.10 to be able to autoload ElggMenuItem");
    	}
	}
	
    public function testGetItemsReturnsOriginalItems() {
		$items = array(
			new MenuItem('name1', 'text1', 'url1'),
			new MenuItem('name2', 'text2', 'url2'),
		);

		$menu = new Menu($items);

		$i = 0;
		foreach ($menu->getItems() as $item) {
			$this->assertEquals($items[$i++], $item);
		}
	}

	public function testRegisterItem() {
		$menu = new Menu();

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
