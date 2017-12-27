<!DOCTYPE html>
<html lang="en">
<head>
  <title>File Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
	.scroll{
		height:600px;
		overflow-y:scroll;
	}
  </style>
</head>
<body>


  
<?php
if(!empty($_GET))$way = $_GET['way'];
else $way = 'www';
 
$dir = scandir('/xampp/htdocs/nizhegorodtsev/FileManager/'.$way);
array_splice($dir, 0, 2); // видаляємо крапки в масиві

$files = array();
$folders = array();
foreach($dir as $key => $value){
	if(strrchr($value, '.')) array_push ($files, $value); //strrchr() - шукає крапку, якщо крапка є array_push() - додає елемент в кінець попередньо створеного масива
	else array_push ($folders, $value);
}
?>

<div class="jumbotron text-center">
  <h1>My First File Manager</h1>
</div>

<div class="container">
<div class="scroll">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Size</th>
      </tr>
    </thead>
    <tbody>
	
	<?php //виводим іконки папок, назви папок, ссилки з гет параметрами для роботи вкладеності
	foreach($folders as $key => $value):?>
      <tr>
        <td><img src="img/folders-icon.png"><a href="?way=<?php echo $way.'/'.$value ?>"><?php echo $value ?></a></td>
        <td>Folder</td>
        <td>- - -</td>
      </tr>	
	<?php endforeach ?>
	
	<?php //виводим іконки різноманітних типів файлів, назви файлів
	foreach($files as $key => $value):?>
		<tr>
	<?php if(strrchr($value, '.') == '.php'):?>
        <td><?php echo '<img src="img/php_icon.png">'.$value ?></td>
	<?php elseif(strrchr($value, '.') == '.html'):?>
        <td><?php echo '<img src="img/html_icon.png">'.$value ?></td>
	<?php elseif(strrchr($value, '.') == '.zip'):?>
        <td><?php echo '<img src="img/zip-icon.jpg">'.$value ?></td>		
	<?php elseif(strrchr($value, '.') == '.xml'):?>
        <td><?php echo '<img src="img/xml-icon.png">'.$value ?></td>
	<?php elseif(strrchr($value, '.') == '.sql'):?>
        <td><?php echo '<img src="img/sql-icon.png">'.$value ?></td>
	<?php elseif(strrchr($value, '.') == '.css'):?>
        <td><?php echo '<img src="img/css-icon.jpg">'.$value ?></td>
	<?php elseif(strrchr($value, '.') == '.js'):?>
        <td><?php echo '<img src="img/js-icon.png">'.$value ?></td>		
	<?php elseif(strrchr($value, '.') == '.jpg'):?>
        <td><?php echo '<img src="img/jpg-icon.jpg">'.$value ?></td>
	<?php elseif(strrchr($value, '.') == '.png'):?>
        <td><?php echo '<img src="img/png-icon.jpg">'.$value ?></td>	
	<?php elseif(strrchr($value, '.') == '.gif'):?>
        <td><?php echo '<img src="img/gif-icon.jpg">'.$value ?></td>			
	<?php else: ?>
        <td><?php echo '<img src="img/files-icon.png">'.$value ?></td>
	<?php endif ?>
        <td><?php echo strrchr($value, '.') ?></td>
        <td><?php echo filesize('/xampp/htdocs/nizhegorodtsev/FileManager/'.$way.'/'.$value)?> b</td>
      </tr>	
	<?php endforeach ?>

    </tbody>
  </table>
  </div>
</div>

</body>
</html>
