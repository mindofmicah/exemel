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
		$this->assertTrue(is_array($obj->children));
		$this->assertEquals(0, count($obj->children));

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

	public function testAppendTo()
	{
		$root  = new MockProperty('root');
		$child = new xml\Property('child'); 
		$this->assertInstanceOf('exemel\Property', $child->appendTo($root));
		$this->assertEquals($child, $root->children[0]);
	}

	public function testAppendWithObjectPassedIn()
	{
		$root = new MockProperty('root');
		$child = new xml\Property('child');
		$this->assertInstanceOf('exemel\Property', $root->append($child));
		$this->assertEquals($child, $root->children[0]);
	}
	public function testAppendWithParam()
	{
		$root = new MockProperty('root');
		$child = new xml\Property('child');

		$this->assertInstanceOf('exemel\Property', $root->append('child', '',array(), $obj));
		$this->assertEquals($child, $root->children[0]);
		$this->assertEquals($child, $obj);
	}

	public function testDynamicAppend()
	{
		$root = new MockProperty('root');
		$this->assertInstanceOf('exemel\Property', $root->append_child('value'));

		$child = new exemel\Property('child', 'value');
		$this->assertEquals($child, $root->children[0]);
	}

	public function testGetTitle()
	{
		$title = 'apples';
		$root = new exemel\Property($title);
		$this->assertEquals($title, $root->getTitle());
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
