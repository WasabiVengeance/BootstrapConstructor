<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

if(!class_exists('bsc_widget_input_text'))
{
	include(__DIR__.'/input_text.php');
}

class bsc_widget_input_text_filter extends bsc_widget_input_text
{
	function init()
	{
		parent::init();
		$this
			->placeholder('Search')
			->prepend('<i class="icon-search"></i>')
			->clear_button('bsc.widget.dataTable.clearSearch(this);');
		
	}
}

?>