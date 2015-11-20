$(document).ready(function() {
	var loading = $('.ajax');
	//Arhiveerimine
	$('.archive-me').click(function() { 
		var nwid = $(this).attr('id');
		var conf = confirm('Olete kindel, et soovite teate "' + $('.nwt-'+nwid).text() + '" arhiveerida?');
		if(conf) {
			$.ajax({
				beforeSend: function() {
					loading.show();
				},
				type: 'POST',
				url: '/archive/',
				data: {'ajax_call_archive' : true, 'news_id' : nwid},
				success: function(data) {
					loading.hide();
					if(data == 'OK') {
						$('tr.nwtr-'+nwid).fadeOut();
					} else {
						alert("Viga teate arhiveerimisel.");
					}
				}
			});
		}
	});
	
	//lõplikult
	$('.check-done').click(function() { 
		var nwid = $(this).attr('id');
		var conf = confirm('Olete kindel, et soovite teate "' + $('.nwt-'+nwid).text() + '" sooritatuks määrata?');
		if(conf) {
			$.ajax({
				beforeSend: function() {
					loading.show();
				},
				type: 'POST',
				url: '/archive/',
				data: {'ajax_call_check_done' : true, 'news_id' : nwid},
				success: function(data) {
					loading.hide();
					$('tr.nwtr-'+nwid).fadeOut();
				}
			});
		}
	});
	
	//tagasi saatmine
	$('.check-undone').click(function() { 
		var nwid = $(this).attr('id');
		var conf = confirm('Olete kindel, et soovite teate "' + $('.nwt-'+nwid).text() + '" tagasi saata?');
		if(conf) {
			$.ajax({
				beforeSend: function() {
					loading.show();
				},
				type: 'POST',
				url: '/archive/',
				data: {'ajax_call_check_undone' : true, 'news_id' : nwid},
				success: function(data) {
					loading.hide();
					$('tr.nwtr-'+nwid).fadeOut();
				}
			});
		}
	});
	

	//Taastamine
	$('.restore-me').click(function() { 
		var nwid = $(this).attr('id');
		var conf = confirm('Olete kindel, et soovite teate "' + $('.nwt-'+nwid).text() + '" taastada?');
		if(conf) {
			$.ajax({
				beforeSend: function() {
					loading.show();
				},
				type: 'POST',
				url: '/archive/',
				data: {'ajax_call_restore' : true, 'news_id' : nwid},
				success: function(data) {
					loading.hide();
					if(data == 'OK') {
						$('tr.nwtr-'+nwid).fadeOut();
					} else {
						alert("Viga teate taastamisel.");
					}
				}
			});
		}
	});
	
	//Kustutamine
	$('.delete-me').click(function() { 
		var nwid = $(this).attr('id');
		var conf = confirm('Olete kindel, et soovite teate "' + $('.nwt-'+nwid).text() + '" kustutada?');
		if(conf) {
			$.ajax({
				beforeSend: function() {
					loading.show();
				},
				type: 'POST',
				url: '/archive/',
				data: {'ajax_call_delete' : true, 'news_id' : nwid},
				success: function(data) {
					loading.hide();
					if(data == 'OK') {
						$('tr.nwtr-'+nwid).fadeOut();
					} else {
						alert("Viga teate kustutamisel.");
					}
				}
			});
		}
	});
	
	$('#jtask i').click(function() {
		var element = $(this), nwid = $(this).attr('id');
		if( element.parent().hasClass('done') ) {
			var conf = confirm('Olete kindel, et loen ülesande "' + $('.nwt-'+nwid).text() + '" mitte sooritatuks?');
			if(conf) {
				$.ajax({
					type: 'POST',
					url: '/archive/',
					data: {'task_uncomplete' : true, 'task_complete_id' : nwid},
					success: function(data) { 
						$(element).parent().removeClass('done').addClass('not-done');
						$(element).removeClass('fa-check').addClass('fa-times');
					}
				});
			}
		} else {
			var conf = confirm('Olete kindel, et loen ülesande "' + $('.nwt-'+nwid).text() + '" sooritatuks?');
			if(conf) {
				$.ajax({
					type: 'POST',
					url: '/archive/',
					data: {'task_complete' : true, 'task_complete_id' : nwid},
					success: function(data) { 
						$(element).parent().removeClass('not-done').addClass('done');
						$(element).removeClass('fa-times').addClass('fa-check');
					}
				});
			}
		}
	}); 
	
});