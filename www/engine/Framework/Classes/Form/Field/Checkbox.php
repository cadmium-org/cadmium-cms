<?php

namespace Form\Field {
	
	use Form, Form\Utils, Request, Tag, Template, Validate;
	
	class Checkbox extends Utils\Field {
		
		# Constructor
		
		public function __construct($form, $name, $value = false, $config = false) {
			
			if ($form instanceof Form) $this->form = $form;
			
			$this->name = $this->validateName($name); $this->value = Validate::boolean($value);
		}
		
		# Catch POST value
		
		public function post() {
			
			if ($this->posted || $this->disabled || (false === ($name = $this->getName()))) return false;
			
			if (null === ($value = Request::post($name))) return false;
			
			$this->value = Validate::boolean($value);
			
			# ------------------------
			
			return ($this->posted = true);
		}
		
		# Get block
		
		public function block() {
			
			$block = new Template\Utils\Group();
			
			# Create hidden field
			
			$attributes['type'] = 'hidden';
			
			$attributes['name'] = $this->getName();
			
			$tag = new Tag('input', $attributes); $block->add($tag->block());
			
			# Create checkbox field
			
			$attributes['type'] = 'checkbox';
			
			$attributes['id'] = $this->getId(); 
			
			if ($this->error) $attributes['data-error'] = 'error';
			
			if ($this->readonly) $attributes['readonly'] = 'readonly';
			
			if ($this->disabled) $attributes['disabled'] = 'disabled';
			
			if ($this->value) $attributes['checked'] = 'checked';
			
			$tag = new Tag('input', $attributes); $block->add($tag->block());
			
			# ------------------------
			
			return $block;
		}
	}
}

?>