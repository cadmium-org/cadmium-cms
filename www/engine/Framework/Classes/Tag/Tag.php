<?php

namespace {
	
	class Tag {
		
		private static $block_default, $block_self_closing;
		
		private $name, $attributes = array(), $contents = null;
		
		# Autoloader
		
		public static function __autoload() {
			
			# Create default block
			
			$block_default = '<$name${ for:attributes } $name$="$value$"{ / for:attributes }>{ block:contents / }</$name$>';
			
			self::$block_default = new Template\Utils\Block($block_default);
			
			# Create self-closing block
			
			$block_self_closing = '<$name${ for:attributes } $name$="$value$"{ / for:attributes } />';
			
			self::$block_self_closing = new Template\Utils\Block($block_self_closing);
		}
		
		# Constructor
		
		public function __construct($name, $attributes, $contents = null) {
			
			$this->name = String::validate($name); $this->attributes = Arr::index($attributes, 'name', 'value');
			
			if (null === $contents) return;
			
			$this->contents = (Template::settable($contents) ? $contents : new Template\Utils\Block(String::output($contents), false));
		}
		
		# Get block
		
		public function block() {
			
			$block = ((null !== $this->contents) ? clone self::$block_default : clone self::$block_self_closing);
			
			$block->name = $this->name; $block->attributes = $this->attributes; $block->contents = $this->contents;
			
			# ------------------------
			
			return $block;
		}
	}
}

?>