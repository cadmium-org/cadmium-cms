<?php

namespace {
	
	class Form {
		
		private $name = false, $fieldset = false, $posted = false, $fields = array();
		
		# Constructor
		
		public function __construct($name) {
			
			$name = String::validate($name);
			
			if (preg_match(REGEX_FORM_NAME, $name)) $this->name = $name;
			
			$this->fieldset = new Form\Utils\Fieldset($this);
		}
		
		# Add field
		
		public function add($field) {
			
			if ((false === $this->name) || $this->posted) return false;
			
			if (!($field instanceof Form\Utils\Field)) return false;
			
			if (false === ($name = $field->name())) return false;
			
			$this->fields[$name] = $field;
			
			# ------------------------
			
			return true;
		}
		
		# Catch POST data
		
		public function post() {
			
			if ((false === $this->name) || $this->posted) return false;
			
			foreach ($this->fields as $name => $field) {
				
				if ($field->disabled()) continue; 
				
				if (null === ($value = Request::post($this->name . '_' . $name))) return false;
			}
			
			foreach ($this->fields as $field) $field->post();
			
			$this->posted = true;
			
			# ------------------------
			
			return $this->fields;
		}
		
		# Return name
		
		public function name() {
			
			return $this->name;
		}
		
		# Return fieldset
		
		public function fieldset() {
			
			return $this->fieldset;
		}
		
		# Check if posted
		
		public function posted() {
			
			return $this->posted;
		}
		
		# Get fields
		
		public function fields() {
			
			$fields = array();
			
			foreach ($this->fields as $field) $fields[$field->name()] = $field->block();
			
			# ------------------------
			
			return $fields;
		}
	}
}

?>