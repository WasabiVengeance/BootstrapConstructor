<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class bsc_widget_local_anchor extends bsc_widget
{
	function init()
	{
		$this->option_order = array('name');
		$this->options['tag'] = 'a';
	}
	
	function option($name,$value)
	{
		switch($name)
		{
			case 'name':
				$this->attributes['name'] = $value;
				break;
		}
		return $this;
	}
}

?>