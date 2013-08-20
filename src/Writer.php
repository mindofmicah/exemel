<?php
namespace exemel;

class Writer 
{
	protected $root;

	public function __construct($root_title = 'root')
	{
		$this->root = new Property($root_title);
	}
}


