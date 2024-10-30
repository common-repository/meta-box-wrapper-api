<?php
class BtMetaSelectField extends BtMetaField
{
	public $options;
	public $multiple;
	
	
	
	function __construct($id, $name, $label, $instruction=false, $options=array(), $multiple=false)
	{
		$this->id = $id;
		$this->name = $name;
		$this->label = $label;
		$this->instruction = $instruction;
		$this->options = $options;
		$this->multiple = $multiple;
	}//eof
	
	
	
	public function render($post)
	{
		$v = get_post_meta($post->ID,$this->name, $this->multiple);
		?>
			<p>
				<label for="<?php echo $this->id ?>"><strong><?php echo $this->label ?></strong></label><br>
				<div style="color:gray; font-size:small;"><?php echo $this->instruction ?></div>
				
				<select name="<?php echo $this->name,$this->multiple?'[]':'' ?>" id="<?php echo $this->id ?>" <?php echo $this->multiple?'multiple':'' ?>>
					<?php
						foreach ($this->options as $opt)
							$opt->render($v);
					?>
        		</select>
			</p>
			<?php
		}
}//eoc