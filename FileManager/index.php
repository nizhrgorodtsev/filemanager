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
		border:1px solid grey;
	}
	.tree{
		margin-left:20px; 
		border-left:1px dashed Silver;
	}
	li{
		background:url(img/closed-folder.jpg) no-repeat left center;
		margin-left:5px;
		padding-left:30px !important;
		margin-top:9px;
	}	

  </style>
</head>
<body>


<script>
$(document).ready(function(){
	var x = document.getElementsByClassName("open");
	var i;
	for (i = 0; i < x.length; i++) {
		x[i].firstElementChild.style.backgroundImage = "url(img/opened-folder.jpg)";
	}
});
</script>
 
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
<div class="row">
	<div class="col-md-3">
		<div class="scroll">
		
			
			<?php 

				
				$tree = explode("/", $way); 
				$folders_left = array();
				$allstring = array();
				foreach($tree as $key => $tree_value){
					if($tree_value == 'www') $i = $tree_value;
					else $i = $i.'/'.$tree_value;
					$dir_left = scandir('/xampp/htdocs/nizhegorodtsev/FileManager/'.$i);
					array_splice($dir_left, 0, 2);	
						foreach($dir_left as $key => $value){
							if(!strrchr($value, '.'))array_push ($folders_left, $value);			
						}
						foreach($folders_left as $key => $value){
							//echo '<li><img src="img/folders-icon.png"><a href="?way='.$i.'/'.$value.'">'.$value.'</a></li>';
							//замість виводу записуємо html код в багаторівневий асоціативний масив
							$string[$value] = '<li><a href="?way='.$i.'/'.$value.'">'.$value.'</a></li>'; 
						}
					$allstring[$tree_value] = $string; 
					$string = array();
					$folders_left = array(); // обовязково очистити	масив 
				}

				//скрипт вкладеності масивів згідно з гет параметрами.
				$num = count($tree); 

				for($i = $num-1; $i>0; $i--){

					$index1 = $tree[$i-1];
					$index2 = $tree[$i];

					$allstring[$index1][$index2] = array($allstring[$index1][$index2], $allstring[$index2]);	
				}
				
				//скрипт виводу багаторівневого асоціативного масиву за допомогою рекурсивної функції
				$switch = '0'; // перемикач
				function print_array($current_array){
					global $switch;				
					foreach($current_array as $key => $current_value){
						if(is_array($current_value)){
						
							switch($switch){
							
								case '0':
								$switch = '1';
								echo '<ul class="list-unstyled open">'; // без відступу і полоси
								print_array($current_value);
								echo '</ul>';
								break;
								
								case '1':
								$switch = '0';
								echo '<ul class="list-unstyled tree">'; // з відступом і полосою
								print_array($current_value);
								echo '</ul>';
								break;	
								
							}
						}
						else echo $current_value;
					}				
				}
				
				echo '<li class="list-unstyled" style="background-image:url(img/opened-folder.jpg)"><a href="?way=www">www</a></li>'; // корінь
				
				//запуск функції виводу масиву
				echo '<ul class="list-unstyled">';
				print_array($allstring['www']);
				echo '</ul>';
				
			?>
				
		</div>
	</div>
	<div class="col-md-9">
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
        <td><img src="img/closed-folder.jpg"><a href="?way=<?php echo $way.'/'.$value ?>"><?php echo $value ?></a></td>
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
  </div>
</div>

</body>
</html>
