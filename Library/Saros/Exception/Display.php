<?php
$traceArr = explode("\n", $e->getTraceAsString());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>An Exception Has Occured</title>
	<style type="text/css">
		#exception
		{
			margin: auto;
			margin-top: 10%;
			text-align: center;
			width: 600px;
			border: 1px solid red;
			background-color: #EFE0E0;
		}
		#body, #className
		{
			padding: 5px;
		}
		#className
		{
			border-bottom: 1px solid red;
			padding-left: 10px;
			font-size: 18px;
			text-align: left;
		}
		#className span
		{
			float: right;
		}
		.message
		{
			margin-top: 10px;
			text-align: left;
		}
		p
		{
			margin: 0;
			border: 1px dashed gray;
			padding: 3px;
			overflow: auto;
		}
		.mono
		{
			font-family: monospace;
			font-size: 12px;
		}
		#trace
		{
			text-align: left;

		}
		.clearer
		{
			clear: both;
		}
	</style>
</head>
<body>
	<div id="exception">
		<div id="className">
			A <b><?php echo get_class($e)?></b> has occurred
			<!--<span>#<?php echo $e->getCode()?></span>-->
		</div>
		<div id="body">
			<div class="message">
				<b>Message:</b><br />
				<p>
					<?php echo $e->getMessage()?>
				</p>
			</div>
			<div class="message">
				<b>Location:</b><br />
				<p class="mono">
					In File: <?php echo $e->getFile()?>, Line: <?php echo $e->getLine()?>
				</p>
			</div>
			<div class="message">
				<b>Trace:</b><br />
				<p class="mono">
					<?php
					foreach($traceArr as $trace)
					{
						echo $trace."<br />";
					}
					?>
				</p>
			</div>
		</div>
	</div>
</body>
</html>