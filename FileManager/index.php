<?php
	ob_start();
	require "head.php";
?>
<body>
<?php
	if(!empty($_GET))$way = $_GET['way'];
	else $way = 'www';
?>
<div class="container">
	<div class="row">
	<?php 
		require "left.php";
		require "right.php";
	?>
	</div>
</div>

<div id="context-menu">
	<p><a id="rename" href="?way=<?php echo $way ?>">Rename</a></p>
	<p><a id="delite" href="?way=<?php echo $way ?>">Delite</a></p>
	<p><a id="info" href="?way=<?php echo $way ?>">Info</a></p>
</div>

</body>
</html>
