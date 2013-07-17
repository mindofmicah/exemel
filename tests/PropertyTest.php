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
	public function testConstructorHasOptionalParams()
	{
		$obj = new MockProperty('title', 'value', array('a'=>'b'));
		$this->assertInstanceOf('exemel\Property', $obj);
		$this->assertEquals('title', $obj->title);
		$this->assertEquals('value', $obj->value);
		$this->assertTrue(is_array($obj->attributes));
		$this->assertEquals(array('a'=>'b'), $obj->attributes);
	}

	public function testRenderWithValueHasAttributes()
	{
		$obj = new xml\Property('apple','pie',array('granny'=>'smith'));
		$this->assertEquals('<apple granny="smith">pie</apple>', $obj->render());
	}	
	public function testRenderWithValueNoAttributes()
	{
		$obj = new xml\Property('apple','pie');
		$this->assertEquals('<apple>pie</apple>', $obj->render());
	}
	public function testRenderNoValueHasAttributes()
	{
		$obj = new xml\Property('apple', null, array('prop'=>'val'));
		$this->assertEquals('<apple prop="val" />', $obj->render());
	}
	public function testRenderNoValueNoAttributes()
	{
		$obj = new xml\Property('apple');
		$this->assertEquals("<apple />", $obj->render());
	}

	public function testRenderAttributesWith()
	{
		$obj = new MockProperty('id',null, array('id1'=>'value', 'id2'=>'value2'));
		$this->assertEquals(' id1="value" id2="value2"', $obj->fakeAttributes());
	}
	public function testRenderAttributesWithOut()
	{
		$obj = new MockProperty('id');
		$this->assertEquals('', $obj->fakeAttributes());
	}

}

class MockProperty extends xml\Property
{
	public function __get($property)
	{
		return is_null($this->$property) ? null : $this->$property;
	}
	public function fakeAttributes()
	{
		return $this->renderAttributes();
	}
}
