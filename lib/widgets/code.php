<?php

class bsc_widget_code extends bsc_widget
{
	function init()
	{
		$this->tag = 'code';
		$this->option('text','');
	}
	
	function render_start()
	{
		$html = parent::render_start();
		$html .= $this->options['text'];
		return $html;
	}
}

?>