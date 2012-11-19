var answers = [];

$(document).ready(function(){
	
	$('.answers li').on('click', function(){
		$(this).parent().find('.checked').removeClass('checked');
		$(this).addClass('checked');
	});
	
	$('.known li').on('click', function(){
		$(this).toggleClass('checked');
		
		if($('p.known_txt').hasClass('error') && $(this).hasClass('checked')){
			$('p.known_txt').removeClass('error');
		}
		
	});
	
	$('p.allow_newsletter').on('click', function(){
		$(this).toggleClass('checked');
	});
	
	var inputs = {
		civilite: 'Civilité',
		nom: 'Nom*',
		prenom: 'Prénom*',
		adresse: 'Adresse*',
		cp: 'Code Postal*',
		ville: 'Ville*',
		email: 'Email*',
		tel: 'Téléphone* (fixe ou mobile)'
	};
	
	$('input, textarea').on('focus', function(){
		
		$(this).removeClass('error');
		
		var name = $(this).attr('name');
		
		if($(this).val() == inputs[name]){
			$(this).val('');
		}
		
	});
	
	$('input, textarea').on('blur', function(){
		
		var name = $(this).attr('name');
		
		if($(this).val() == ''){
			$(this).val(inputs[name]);
		}
		
	});
		
	$('#validate').on('click', function(){
		checkQuizz();
	});
	
	$('#next_step').on('click', function(){
		checkForm();
	});
	
	function checkQuizz(){
		
		$('.question').removeClass('error');
		
		var answers_nb = $('#quizz').find('.checked').size();
		if(answers_nb == 3){
			var q1 = parseInt($('.question:eq(0)').find('.checked').prevAll('li').size()+1);
			var q2 = parseInt($('.question:eq(1)').find('.checked').prevAll('li').size()+1);
			var q3 = parseInt($('.question:eq(2)').find('.checked').prevAll('li').size()+1);
			
			answers = [q1, q2, q3];	
						
			$('#quizz').fadeOut(function(){
				
				$('#formulaire').fadeIn();
				
			});
			
		}else{
			$('.question').each(function(){
				if($(this).find('.checked').size() == 0){
					$(this).addClass('error');
				}
			});
		}
		
	}
	
	function checkForm(){
		
		$('select[name="civilite"]').removeClass('error');
		
		$.each(inputs, function(key, v){
			
			var input = $('input[name="'+key+'"]');
			
			if(key == 'civilite'){
				input = $('select[name="civilite"]');
			}
			
			if(key == 'adresse'){
				input = $('textarea[name="adresse"]');
			}
			
			if($(input).val() == v){
				$(input).addClass('error');
			}
			
			if(key == 'email'){
				if(!checkEmail($(input).val())){
					$(input).addClass('error');
				}
			}
						
		});
		
		if($('ul.known').find('li.checked').size() == 0){
			$('ul.known').prevAll('p').addClass('error');
		}
				
		if($('#form_content').find('.error').size() == 0){
			
			var user = {};
			var known = [];
			
			$.each(inputs, function(key, v){
				
				var input = $('input[name="'+key+'"]');
				
				if(key == 'civilite'){
					input = $('select[name="civilite"]');
				}
				
				if(key == 'adresse'){
					input = $('textarea[name="adresse"]');
				}
				
				user[key] = $(input).val();
											
			});
			
			if($('input[name="societe"]').val() == 'Société'){ $('input[name="societe"]').val('N/C'); }
			if($('input[name="societe"]').val() == 'Fonction'){ $('input[name="fonction"]').val('N/C'); }

			user['societe'] = $('input[name="societe"]').val();
			user['fonction'] = $('input[name="fonction"]').val();

			$('ul.known').find('li.checked').each(function(){
				known.push($(this).text());	
			});
			
			if($('p.allow_newsletter').hasClass('checked')){
				user.newsletter = 1;
			}else{
				user.newsletter = 0;
			}
			
			var data = {
				user: user,
				known: known,
				quizz: answers
			}
			
			$.ajax({
			  type: "POST",
			  url: "http://www.showa-europe.com/jeu-concours-fb/play.php",
			  dataType: "json",
			  data: data
			}).done(function(response){
				
				if(typeof response != 'undefined' && response.success == true){
					$('#formulaire').fadeOut(function(){
						$('#participation_ok').fadeIn();
					});
				}else{

					if(response.error == 'already'){

						$('#participation_ok p').html('<strong>Vous avez déjà participé au concours.</strong>')

						$('#formulaire').fadeOut(function(){
							$('#participation_ok').fadeIn();
						});
					}else{

						$('#participation_ok p').html('<strong>Une erreur s\'est produite. Veuillez recommencer ultérieurement.</strong>')

						$('#formulaire').fadeOut(function(){
							$('#participation_ok').fadeIn();
						});

					}

				}
				
			});
						
		}
		
	}
	
	function checkEmail(email) { 
	    var regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
	    return regex.test(email);
	} 
	
});