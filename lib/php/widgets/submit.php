<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

class bsc_widget_submit extends bsc_widget
{
	function init()
	{
		$this->options['tag'] = 'button';
		$this->option('label','');
		$this->option('class','btn');
	}
	
	function option($name,$value)
	{
		switch($name)
		{
			case 'size':
			case 'emphasis':
				$this->options['css']['btn-'.$value] = true;
				break;
			default:
				parent::option($name,$value);
				break;
		}
		return $this;
	}
	
	function render_start($data = array())
	{
		$html = '<'.$this->options['tag'].' type="submit"'.$this->get_attributes().'>';
		$html .= $this->options['label'];
		return $html;
	}
}

?>