<?php
namespace exemel;

class Property
{
	protected $title;
	protected $value;
	protected $attributes = array();
	public function __construct($title, $value = null, $attributes = array())
	{
		$this->title = $title;
		$this->value = $value;
		$this->attributes = $attributes;
	}

	public function render()
	{
		if ($this->value) {
			return sprintf(
				'<%s%s>%s</%s>', 
				$this->title, 
				$this->renderAttributes(), 
				$this->value, 
				$this->title
			);
		}
		return sprintf('<%s%s />', $this->title, $this->renderAttributes());		
	}

	protected function renderAttributes()
	{
		$ret = '';
		$glue = ' ';
		foreach ($this->attributes as $k=>$p) {
			$ret.= sprintf('%s%s="%s"', $glue, $k, $p);
		}		
		return $ret;
	}
}
