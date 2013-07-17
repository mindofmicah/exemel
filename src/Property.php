<?php
namespace exemel;

class Property
{
	protected $title;
	protected $value;
	protected $attributes = array();
	public function __construct($title)
	{
		$this->title = $title;
	}
}
