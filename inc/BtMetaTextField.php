<?php
class BtMetaTextField extends BtMetaField
{
	public $placeholder;
	
	function __construct($id, $name, $label, $instruction=false, $placeholder='')
	{
		$this->name = $name;
		$this->id = $id;
		$this->label = $label;
		$this->instruction = $instruction;
		$this->placeholder = $placeholder;
	}
	
	public function render($post)
	{
		$v = get_post_meta($post->ID,$this->name, true);
		?>
		<p>
			<b><?php echo $this->label; ?></b>
			<span style="color:gray; font-size:x-small;"><?php echo $this->instruction; ?></span>
			<input 
			style="width:100%" 
			name="<?php echo $this->name; ?>"  
			type="text" 
			id="<?php echo $this->id; ?>" 
			<?php if($v) echo 'value="'.esc_attr($v).'"'; ?> 
			/>
		</p>
		<?php
	}
}