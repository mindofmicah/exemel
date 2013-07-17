<?php
use exemel as xml;
require 'src/Property.php';

class PropertyTest extends PHPUnit_Framework_TestCase
{
	public function testConstructorNoOptionalParams()
	{
		$obj = new MockProperty('title');
		$this->assertInstanceOf('exemel\Property', $obj);
		$this->assertEquals('title', $obj->title);
		$this->assertEquals('', $obj->value);
		$this->assertTrue(is_array($obj->attributes));
		$this->assertEquals(0, count($obj->attributes));
	}
	
}

class MockProperty extends xml\Property
{
	public function __get($property)
	{
		return is_null($this->$property) ? null : $this->$property;
		return $this->property;
	}
}
