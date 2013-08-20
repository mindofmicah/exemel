<?php
namespace exemel;

class Property
{
	protected $title;
	protected $value;
	protected $attributes = array();
	protected $children = array();

	public function __construct($title, $value = null, $attributes = array())
	{
		$this->title = $title;
		$this->value = $value;
		$this->attributes = $attributes;
	}


	/**
 	 * Flatten the property into a standard XML property
	 *
	 * @return string
	 */
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

	/**
	 * Flattens the attribute array into a string of the format key="value"
 	 *
	 * @return string
	 */
	protected function renderAttributes()
	{
		$ret = '';
		$glue = ' ';
		foreach ($this->attributes as $k=>$p) {
			$ret.= sprintf('%s%s="%s"', $glue, $k, $p);
		}		
		return $ret;
	}

	public function append($property, $value = null, $attributes = array(), &$obj = null)
	{
		if ($property instanceof Property) {
			$this->children[] = $property;
		} else {
			$obj = new Property($property, $value, $attributes);
			$this->children[] = $obj;
		}

		return $this;
	}
	public function appendTo(Property $parent)
	{
		$parent->append($this);
		return $this;				
	}

	public function __call($func, $params)
	{
		if (preg_match('%append_([A-z]+)%', $func, $match)) {
//			print_r($match);
			array_unshift($params, $match[1]);
			return call_user_func_array(array($this, 'append'), $params);
		}
//		print_r(func_get_args());
	}

	public function getTitle()
	{
		return $this->title;
	}	
}
