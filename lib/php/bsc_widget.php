<?php
# Copyright 2013 Mike Thorn (github: WasabiVengeance). All rights reserved.
# Use of this source code is governed by a BSD-style
# license that can be found in the LICENSE file.

abstract class bsc_widget
{
	public function __construct()
	{
		global $__bsc;
		
		$args = func_get_args();
		
		$this->parent = null;
		$this->children = array();
		$this->events = array();
		$this->type = array_shift($args);
		$this->attributes = array();
		$this->option_order = null;
		$this->disable_translate = false;
		
		$this->option_attributes = array('id','name','value');
		
		$this->options = array(
			'icon'=>null,
			'tag'=>'',
			'css'=>array(),
			'style'=>'',
		);
		$this->init();
		
		$class = get_class($this);
		if(isset($__bsc['autooptions'][$class]) && is_array($__bsc['autooptions'][$class]))
		{
			bsc::log('found autooptions for '.$class);
			foreach($__bsc['autooptions'][$class] as $name=>$value)
			{
				$this->option($name,$value);
			}
		}
	
		for($i=0; $i<count($args); $i++)
		{
			$this->option($this->option_order[$i],$args[$i]);
		}
		
	}
	
	public function init()
	{
	}
	
	public function __call($option_name,$parameters)
	{
		return $this->option($option_name,$parameters[0]);
	}
	
	public function __options($options)
	{
		if(is_array($options))
		{
			foreach($options as $name=>$value)
			{
				$this->option($name,$value);
			}
		}
		return $this->options;
	}
	
	public function option($name,$value=null)
	{
		global $__bsc;
		switch($name)
		{
			case 'active':
				$this->options['css']['active'] = true;
				break;
			case 'disable_translate':
				$this->disable_translate = true;
				break;
			case 'col':
				if(is_array($value))
				{
					$this->class('col-xs-'.$value[0]);
					$this->class('col-sm-'.$value[1]);
					$this->class('col-md-'.$value[2]);
					$this->class('col-lg-'.$value[3]);
				}
				else
				{
					$this->class('col-xs-'.$value);
					$this->class('col-sm-'.$value);
					$this->class('col-md-'.$value);
					$this->class('col-lg-'.$value);
				}
				break;
			case 'offset':
				if(is_array($value))
				{
					$this->class('col-xs-offset-'.$value[0]);
					$this->class('col-sm-offset-'.$value[1]);
					$this->class('col-md-offset-'.$value[2]);
					$this->class('col-lg-offset-'.$value[3]);
				}
				else
				{
					$this->class('col-xs-offset-'.$value);
					$this->class('col-sm-offset-'.$value);
					$this->class('col-md-offset-'.$value);
					$this->class('col-lg-offset-'.$value);
				}
				break;
			case 'class':
				$this->options['css'][$value] = true;
				break;
			case 'style':
				$this->options['style'] .= $value;
				break;
			case 'pull':
				$this->options['css']['pull-'.$value] = true;
				break;
			case 'clearfix': case 'muted':
				$this->options['css'][$name] = true;
				break;
			default:
				if(in_array($name,$this->option_attributes))
				{
					if($name == 'id')
						$__bsc['id_positions'][$value] = $this;
					$this->attributes[$name] = $value;
				}
				else if(in_array($name,$__bsc['events']))
				{
					if(!isset($this->events[$name]))
						$this->events[$name] = '';
					$this->events[$name] .= $value;
				}
				else
				{
					$this->options[$name] = $value;
				}
				break;
		}
		return $this;
	}
	
	public function attribute($name,$value)
	{
		$this->attributes[$name] = $value;
		return $this;
	}
	
	public function add()
	{
		$params = func_get_args();
		$param_count = count($params);
		for($i=0;$i<$param_count;$i++)
		{
			if(is_array($params[$i]))
			{
				$this->add($params[$i]);
			}
			else if (is_object($params[$i]))
			{
				#bsc::log('about to set parent');
				$params[$i]->parent = $this;
				#bsc::log('parent set!');
				$this->children[] = $params[$i];
			}
			else
			{
				$this->add(bsc::text($params[$i]));
				
			}

		}
		return $this;
	}
	
	public function add_to_id()
	{
		global $__bsc;
		$params = func_get_args();
		$id = array_shift($params);
		bsc::log('trying to add to id '.$id);
		$__bsc['id_positions'][$id]->add($params[0]);
		return $this;
	}
	
	protected function __get_css()
	{
		$html = '';
		
		if(isset($this->options['span']) && is_numeric($this->options['span']))
		{
			#$this->options['css']['span'.$this->options['span']] = true;
			$this->options['css']['col'] = true;
			$this->options['css']['col-lg-'.$this->options['span']] = true;
		}
		
		$classes = array_keys($this->options['css']);
		if(count($classes) > 0)
			$html .= ' class="'.implode(' ',$classes).'"';
		if($this->options['style'] != '')
			$html .= ' style="'.$this->options['style'].'"';
		return $html;
	}
	
	protected function __get_events()
	{
		$html = '';
		foreach($this->events as $type=>$js)
		{
			$html .= ' '.$type.'="'.$js.'"';
		}
		return $html;
	}
	
	protected function get_attributes()
	{
		$html = $this->__get_css() . $this->__get_events();
		foreach($this->attributes as $name=>$value)
		{
			$html .= ' '.$name.'="'.$value.'"';
		}
		return $html;
	}

	public function render($data=array())
	{
		$html = '';
		
		if(isset($this->options['on_render_start']))
		{
			$func = $this->options['on_render_start'];
			$return = $func($this,$data);
			if(isset($return))
				$html .= $return;
		}
		
		$html .= $this->render_start($data);
		$html .= $this->render_children($data);
		$html .= $this->render_end($data);

		if(isset($this->options['on_render_end']))
		{
			$func = $this->options['on_render_end'];
			$return = $func($this,$data);
			if(isset($return))
				$html .= $return;
		}
		return $html;
	}
	
	protected function __translate($text)
	{
		global $__bsc;
		return (isset($__bsc['hooks']['translator']) && $this->disable_translate !== true)?$__bsc['hooks']['translator']($text):$text;
	}
	
	protected function render_start($data=array())
	{
		if($this->options['tag'] == '')
			return '';
		return '<'.$this->options['tag'].$this->get_attributes().'>';
	}
	
	protected function render_children($data=array())
	{
		$html = '';		
		foreach($this->children as $child)
		{
			$html .= $child->render($data);
		}
		return $html;
	}
	
	protected function render_end($data=array())
	{
		if($this->options['tag'] == '')
			return '';
		return '</'.$this->options['tag'].'>';
	}
	
	function __toString()
	{
		return $this->render();
	}
	
	function __render_icon($pos)
	{
		if(isset($this->options[$pos.'icon']))
		{
			return (($pos == 'pre')?'':' ').'<i class="icon-'.$this->options[$pos.'icon'].'"></i>'.(($pos == 'pre')?' ':'');
		}
		return '';
	}
}

?>