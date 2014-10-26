<?php
namespace Evan\Structs;

use PHPUnit_Framework_TestCase as TestCase;

class ArrayCollectionTest extends TestCase {
	public function testCountIsAccurate() {
		$zeroItems = new ArrayCollection();
		$this->assertEquals(0, count($zeroItems));
		
		$oneItem = new ArrayCollection(array('one'));
		$this->assertEquals(1, count($oneItem));
		
		$twoItems = new ArrayCollection(array('one', 'two'));
		$this->assertEquals(2, count($twoItems));
	}
	
	public function testHasDoesNotImplicitlyCastSimilarValues() {
		$collection = new ArrayCollection(array('1', false));
		
		$this->assertTrue($collection->has('1'));
		$this->assertTrue($collection->has(false));

		$this->assertFalse($collection->has(1));
		$this->assertFalse($collection->has(0));
		$this->assertFalse($collection->has(''));
	}
	
	public function testIsTraversable() {
		$collection = new ArrayCollection(array('one', 'two', 'three'));
		
		$items = array();
		foreach ($collection as $item) {
			$items[] = $item;
		}
		
		$this->assertEquals(array('one', 'two', 'three'), $items);
	}
	
	public function testIsFilterable() {
		$collection = new ArrayCollection(array(0, 1, 2, 3, 4));
		
		$filtered = $collection->filter(function($number) {
			return $number > 2;
		});
		
		$this->assertFalse($filtered->has(0));
		$this->assertFalse($filtered->has(1));
		$this->assertFalse($filtered->has(2));
		$this->assertTrue($filtered->has(3));
		$this->assertTrue($filtered->has(4));
		$this->assertEquals(2, count($filtered));
		$this->assertNotSame($filtered, $collection);
	}
	
	public function testIsMappable() {
		$collection = new ArrayCollection(array(0, 1, 2, 3, 4));
		
		$mapped = $collection->map(function($number) {
			return $number * 2;
		});
		
		$this->assertTrue($mapped->has(0));
		$this->assertTrue($mapped->has(2));
		$this->assertTrue($mapped->has(4));
		$this->assertTrue($mapped->has(6));
		$this->assertTrue($mapped->has(8));
		$this->assertEquals(5, count($mapped));
		$this->assertNotSame($mapped, $collection);
	}
}
