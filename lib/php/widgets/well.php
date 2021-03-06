<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class bsc_widget_well extends bsc_widget
{
	function init()
	{
		$this->option_order = array('size');
		$this->options['tag'] = 'div';
		$this->class('well');
	}
	
	
	function option($name,$value)
	{
		switch($name)
		{
			case 'size':
				$this->options['css']['well-'.$value] = true;
				break;
			default:
				parent::option($name,$value);
				break;
		}
		return $this;
	}
}

?>