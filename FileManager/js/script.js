//<!-------------  зміна зображення для відкритої папки ------------------>

$(document).ready(function(){
	var x = document.getElementsByClassName("open");
	var i;
	for (i = 0; i < x.length; i++) {
		x[i].firstElementChild.style.backgroundImage = "url(img/opened-folder.jpg)";
	}
});

//<!------------------ вивід контекстного меню клік пр. кн. мишки -------------------------->	
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

//<!---------------------- імітація натискання схованої кнопки визова модального вкна редагування файлу  ------------------------------>	
		$(document).ready(function(){
			if($('[data-target="#EditModal"]').html() == 1){
				$('[data-target="#EditModal"]').click();
			} 
		});

//<!------------ Заміна картинок відповідно до клікнутої ссилки --------------->
				$(document).ready(function(){
					var way = $('.modal-body img').attr('data-src');
					$('[data-target="#myModal"]').click(function(){
						var src = way + $(this).html();
						$('.modal-body img').attr('src', src);
					});				
				});
//<!------------- імітація кліку по прихованій кнопці поза межам форми -------------->
					$(document).ready(function(){
						$('[data-action="submit"]').click(function(){
							$('#save_file').click();
						});
					});
//<!---------------------- імітація натискання схованої кнопки визова модального вкна перейменування файлу  ------------------------------>	
			$(document).ready(function(){
				
				if($('[data-target="#RenameModal"]').html() == 1) $('[data-target="#RenameModal"]').click();
				
				$("#imitRnmSubmit").click(function(){
					$("#rnmSubmit").click();
				});
				// планую дописати value = поточна назва
			});

			
