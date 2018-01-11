<?php
ob_start();
?>
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
	a:focus, a:hover {
	outline:none;
	text-decoration:none;
	}
	.scroll{
		height:600px;
		overflow-y:scroll;
		border:1px solid grey;
		margin-top:15px;
	}
	.tree{
		margin-left:20px; 
		border-left:1px dashed Silver;
	}
	li{
		background:url(img/closed-folder.jpg) no-repeat left center;
		margin-left:8px;
		padding-left:30px !important;
		margin-top:9px;
	}

	#context-menu p{
		border-bottom:1px solid silver;
		padding:5px 10px;
		margin:0;
	}
	#context-menu p:last-child{
		border-bottom:0;
	}
	#context-menu{
		background:#fff;
		display:none;
		position:absolute;
		border:1px solid silver;
		border-radius:5px;
		font-size:18px;
	}
  </style>
</head>
<body>

<!-------------  зміна зображення для відкритої папки ------------------>
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
<!--
<div class="jumbotron text-center">
  <h1>My First File Manager</h1>
</div>
-->

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
<!------------------ вивід контекстного меню клік пр. кн. мишки -------------------------->	
	<script>
		$(document).ready(function(){
			var conClick = $("#rename").attr("href");
			$('.rightClick').contextmenu(function(event){
				$('#context-menu').css({
					display: 'block',
					left: event.pageX,
					top: event.pageY
				});
				//Запис гетпараметрів для ренейма видалення та інфо
				$("#rename").attr('href', conClick + '&rename=' + $(this).html());
				$("#delite").attr('href', conClick + '&delite=' + $(this).html());
				$("#info").attr('href', conClick + '&info=' + $(this).html());				
				return false;
			});
			$("body").click(function(e) {
				if($(e.target).closest("#context-menu").length==0) $("#context-menu").css("display","none");
			});
			$('.scroll').scroll(function(){
				$("#context-menu").css("display","none");
			});
		});
	</script>
	<?php //виводим іконки різноманітних типів файлів, назви файлів
	foreach($files as $key => $value):?>
		<tr>
	<?php if(strrchr($value, '.') == '.php'):?>
        <td><img src="img/php_icon.png"><a class="rightClick" href="?way=<?php echo $way ?>&edit=<?php echo $value ?>"><?php echo $value ?></a></td>
	<?php elseif(strrchr($value, '.') == '.html'):?>
        <td><img src="img/html_icon.png"><a class="rightClick" href="?way=<?php echo $way ?>&edit=<?php echo $value ?>"><?php echo $value ?></a></td>
	<?php elseif(strrchr($value, '.') == '.zip'):?>
        <td><?php echo '<img src="img/zip-icon.jpg">'.$value ?></td>		
	<?php elseif(strrchr($value, '.') == '.xml'):?>
        <td><img src="img/xml-icon.png"><a class="rightClick" href="?way=<?php echo $way ?>&edit=<?php echo $value ?>"><?php echo $value ?></a></td>
	<?php elseif(strrchr($value, '.') == '.sql'):?>
        <td><?php echo '<img src="img/sql-icon.png">'.$value ?></td>
	<?php elseif(strrchr($value, '.') == '.css'):?>
        <td><img src="img/css-icon.jpg"><a class="rightClick" href="?way=<?php echo $way ?>&edit=<?php echo $value ?>"><?php echo $value ?></a></td>
	<?php elseif(strrchr($value, '.') == '.js'):?>
        <td><img src="img/js-icon.png"><a class="rightClick" href="?way=<?php echo $way ?>&edit=<?php echo $value ?>"><?php echo $value ?></a></td>		
	<?php elseif(strrchr($value, '.') == '.jpg'):?>
        <td><img src="img/jpg-icon.jpg"><a class="rightClick" href="" data-toggle="modal" data-target="#myModal"><?php echo $value ?></a></td>
	<?php elseif(strrchr($value, '.') == '.png'):?>
        <td><img src="img/png-icon.jpg"><a class="rightClick" href="" data-toggle="modal" data-target="#myModal"><?php echo $value ?></a></td>	
	<?php elseif(strrchr($value, '.') == '.gif'):?>
        <td><img src="img/gif-icon.jpg"><a class="rightClick" href="" data-toggle="modal" data-target="#myModal"><?php echo $value ?></a></td>			
	<?php else: ?>
        <td><img src="img/files-icon.png"><a class="rightClick" href="?way=<?php echo $way ?>&edit=<?php echo $value ?>"><?php echo $value ?></a></td>
	<?php endif ?>
        <td><?php echo strrchr($value, '.') ?></td>
        <td><?php echo filesize('/xampp/htdocs/nizhegorodtsev/FileManager/'.$way.'/'.$value)?> b</td>
      </tr>	
	<?php endforeach ?>
	
<!-------------------- Прхована кнопка виклику модального вікна редагування файлу -------------------------->	
	<button data-toggle="modal" data-target="#EditModal" style="display:none;">
	<?php 
					if(!empty($_GET['edit']) and empty($_POST['EditFile'])){
					echo '1';
					}
					else echo '0';
	?>
	</button>
<!---------------------- імітація натискання схованої кнопки визова модального вкна редагування файлу  ------------------------------>	
	<script>
		$(document).ready(function(){
			if($('[data-target="#EditModal"]').html() == 1){
				$('[data-target="#EditModal"]').click();
			} 
		});
	</script>	
    </tbody>
  </table>
		  <!-- Modal прегеляд зображень-->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">View Image</h4>
			  </div>
			  <div class="modal-body">
				<img class="img-responsive center-block" data-src="<?php echo $way.'/' ?>">
				<!------------ Заміна картинок відповідно до клікнутої ссилки --------------->
				<script>
				$(document).ready(function(){
					var way = $('.modal-body img').attr('data-src');
					$('[data-target="#myModal"]').click(function(){
						var src = way + $(this).html();
						$('.modal-body img').attr('src', src);
					});				
				});
				</script>
				
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		  <!-- Modal -->
		  
		  
		  <!-- Modal Редагування файлів -->
		<div id="EditModal" class="modal fade" role="dialog">
		  <div class="modal-dialog modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit File</h4>
			  </div>
			  <div class="modal-body">
			  <form method="post">
			  <textarea name="EditFile" style="min-height:400px; width:100%;">
				<?php 
					if(!empty($_GET['edit'])){
						$str = file($way.'/'.$_GET['edit']);
						foreach($str as $key => $value)	{
							echo $value;
						}
						//echo file_get_contents($way.'/'.$_GET['edit']);
					}
					else echo '';
					if(!empty($_POST['EditFile']))
						file_put_contents($way.'/'.$_GET['edit'], $_POST['EditFile']); 					
				?>
				</textarea>
				<button id="save_file" type="submit" style="display:none;"></button>
				</form>
				<!------------- імітація кліку по прихованій кнопці поза межам форми -------------->
				<script>
					$(document).ready(function(){
						$('[data-action="submit"]').click(function(){
							$('#save_file').click();
						});
					});
				</script>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-action="submit">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		  <!-- Modal -->
		  
		  

<!-- Trigger the modal Rename -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#RenameModal" style="display:none;">
<?php 
	if(!empty($_GET['rename']) and empty($_POST['RenameName'])){
		echo '1';
	}
	else{
		echo '0';
	}
?>  
  
</button>

  <!-- Modal Rename -->
  <div class="modal fade" id="RenameModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Rename File</h4>
        </div>
        <div class="modal-body">
		  <form method="post">
			<div class="form-group">
			  <label for="rnm">Enter new name:</label>
			  <input type="text" class="form-control" id="rnm" name="RenameName">
			</div>
			<input type="submit" id="rnmSubmit" style="display:none;">
		  </form>
        </div>
        <div class="modal-footer">
		  <button type="button" class="btn btn-default" id="imitRnmSubmit">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <script>
			$(document).ready(function(){
				
				if($('[data-target="#RenameModal"]').html() == 1) $('[data-target="#RenameModal"]').click();
				
				$("#imitRnmSubmit").click(function(){
					$("#rnmSubmit").click();
				});
				// планую дописати value = поточна назва
			});

			
		  </script>
        </div>
      </div>
      
    </div>
  </div>
  
  <?php 
	if(!empty($_POST['RenameName'])){
		$oldName = $way.'/'.$_GET['rename'];
		$newName = $way.'/'.$_POST['RenameName'];
		rename($oldName, $newName);
		header("Location: ?way=".$way);
		}
		
  ?>
		  
		  
  </div>
  </div>
  </div>
</div>

<div id="context-menu">
		<p><a id="rename" href="?way=<?php echo $way ?>">Rename</a></p>
		<p><a id="delite" href="?way=<?php echo $way ?>">Delite</a></p>
		<p><a id="info" href="?way=<?php echo $way ?>">Info</a></p>
</div>

</body>
</html>
