<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class bsc_widget_nav extends bsc_widget
{
	function init()
	{
		$this->default_option = 'type';
		$this->class('nav');
		$this->options['tag'] = 'ul';
	}
	
	function option($name,$value)
	{
		switch($name)
		{
			case 'type':
				if(!is_null($value) && $value != '')
				{
					if($value == 'breadcrumb')
					{
						unset($this->options['css']['nav']);
						$this->options['css']['breadcrumb'] = true;
					}
					else
					{
						$this->class('nav-'.$value);
					}
				}
				break;
			case 'stacked':
				$this->class('nav-'.$name);
				break;
			default:
				parent::option($name,$value);
				break;
		}
		return $this;
	}
	
	function render_start($data)
	{
		global $__bsc;
		
		
		return parent::render_start($data);
	}
}

?>