<!DOCTYPE html>
<html lang="en">
<head>
  <title>File Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>My First File Manager</h1>
</div>
  
<div class="container">
<?php 
$dir = scandir('/xampp/htdocs/nizhegorodtsev/FileManager/www');
array_splice($dir, 0, 2); // видаляємо крапки в масиві

$files = array();
$folders = array();
foreach($dir as $key => $value){
	if(strstr($value, '.')) array_push ($files, $value); //strstr() - шукає крапку, якщо крапка є array_push() - додає елемент в кінець попередньо створеного масива
	else array_push ($folders, $value);
}

?>
</div>

<div class="container">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Size</th>
      </tr>
    </thead>
    <tbody>
	<?php 
	foreach($folders as $key => $value):?>
      <tr>
        <td><?php echo '<img src="img/folders-icon.png">'.$value ?></td>
        <td>DIR</td>
        <td>- - -</td>
      </tr>	
	<?php endforeach ?>
	
	<?php
	foreach($files as $key => $value){
	if(strstr($value, '.') == '.php'):?>
      <tr>
        <td><?php echo '<img src="img/php_icon.png">'.$value ?></td>
        <td><?php echo strstr($value, '.') ?></td>
        <td><?php echo filesize('/xampp/htdocs/nizhegorodtsev/FileManager/www/'.$value)?> b</td>
      </tr>		
	<?php else: ?>
      <tr>
        <td><?php echo '<img src="img/files-icon.png">'.$value ?></td>
        <td><?php echo strstr($value, '.') ?></td>
        <td><?php echo filesize('/xampp/htdocs/nizhegorodtsev/FileManager/www/'.$value)?> b</td>
      </tr>
	<?php endif; } ?>

    </tbody>
  </table>
</div>

</body>
</html>
