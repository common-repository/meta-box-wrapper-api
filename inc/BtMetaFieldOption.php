<?php
class BtMetaFieldOption
{
	public $value;
	public $label;
	
	function __construct($value, $label)
	{
		$this->value = $value;
		$this->label = $label;
	}//eof
	
	public function render($selectedValue)
	{
		if(is_array($selectedValue) && in_array($this->value, $selectedValue))
			$selectedValue = $this->value;
		else
			$selectedValue = null;
			
		?>
		<option value="<?php echo $this->value ?>" <?php selected( $selectedValue, $this->value ); ?>>
			<?php echo $this->label ?>
		</option>
		<?php
	}//eof
}//eoc