<?php
abstract class BtMetaField
{
	public $id;
	public $name;
	public $label;
	public $instruction;

	public abstract function render($post);
	
	public function save($post_id)
	{
		if( isset($_POST[$this->name]) && $_POST[$this->name]!='' )
			update_post_meta( $post_id, $this->name, $_POST[$this->name] );
	}//eof
}//eoc