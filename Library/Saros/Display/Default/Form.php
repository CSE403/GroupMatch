<table border="1">
<tr>
	<th>Description</th>
	<th>Input</th>
</tr>
<?php foreach($this->elements as $element): ?>
<tr>
	<td>
		<label><?php echo $element->getLabel()?>
		<?php
		if ($element->hasDescription())
		{
			?>
		<span><?php echo $element->getDescription();?></span>
		<?php
		}
		?>
		</label>
	</td>
		
	<td>
		<?php echo $element->render()?>
		<?php
		
		if ($element->hasErrors())
		{
			?>
			<ul>
			<?php foreach ($element->getErrors() as $error)
			{
				?>
				<li><?php echo $error ?></li>
				<?php
			}
			?>
			</ul>
			<?php
		}
		
		?>
	</td>
	
</tr>
<?php
endforeach;

if (isset($this->submit))
{
?>

<tr>
	<td colspan="2"><?php echo $this->submit->render() ?></td>
</tr>
<?php
}
?>
</table>
