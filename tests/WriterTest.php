<?php
require 'src/Writer.php';
require 'src/Property.php';

use \exemel;
class WriterTest extends PHPUnit_Framework_TestCase
{
	public function testConstructorDefaults()
	{
		$xml = new MockWriter;
	
		$this->assertInstanceOf("exemel\Property", $xml->root);
		$this->assertEquals('root', $xml->root->getTitle());
	}
	
	public function testConstructorWithParam()
	{
		$root_title = 'product';
		$xml = new MockWriter($root_title);
		$this->assertInstanceOf("exemel\Property", $xml->root);
		$this->assertEquals($root_title, $xml->root->getTitle());
	}
}

class MockWriter extends exemel\Writer
{
	public function __get($val)
	{
		return $this->$val;
	}
	public function __set($key, $val)
	{
		$this->$key = $val;
	}
} 


