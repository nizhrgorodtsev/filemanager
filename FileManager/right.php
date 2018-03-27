<?php 
$dir = scandir(__DIR__ . '/' . $way);
array_splice($dir, 0, 2); // видаляємо крапки в масиві

$files = array();
$folders = array();
foreach($dir as $key => $value){
	if(strrchr($value, '.')) array_push ($files, $value); //strrchr() - шукає крапку, якщо крапка є array_push() - додає елемент в кінець попередньо створеного масива
	else array_push ($folders, $value);
}
?>	
	
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
					if(!empty($_GET['edit'])){
					echo '1';
					}
					else echo '0';
	?>
	</button>

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
			  <textarea name="EditFile" style="min-height:400px; width:100%;"><?php 
					if(!empty($_GET['edit'])){
						$str = file($way.'/'.$_GET['edit']);
						foreach($str as $key => $value)	{
							echo $value;
						}
						//echo file_get_contents($way.'/'.$_GET['edit']);
					}
					else echo '';
					if(!empty($_POST['EditFile'])){
						file_put_contents($way.'/'.$_GET['edit'], $_POST['EditFile']);	
						header("Location: ?way=".$way);								
						}			
				?>
				</textarea>
				<button id="save_file" type="submit" style="display:none;"></button>
				</form>

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
	if(!empty($_GET['rename'])){
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