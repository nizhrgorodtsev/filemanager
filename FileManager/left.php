	<div class="col-md-3">
		<div class="scroll">
			
			<?php 
				$tree = explode("/", $way); 
				$folders_left = array();
				$allstring = array();
				foreach($tree as $key => $tree_value){
					if($tree_value == 'www') $i = $tree_value;
					else $i = $i.'/'.$tree_value;
					$dir_left = scandir(__DIR__ . '/' . $i);
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