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
}