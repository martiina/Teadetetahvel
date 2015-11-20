$(document).ready(function(){
  
	var loader2 = $('.loader-2');
  
	$('input').iCheck({
		checkboxClass: 'icheckbox_minimal-blue',
		radioClass: 'iradio_minimal-blue',
		increaseArea: '20%' // optional
	});
  
	// Sidebar -> cookie
	$('#sidebar-collapse').bind('click', function() { 
		var effect_element = $('.fixed-menu');
		var state = 0;
		effect_element.toggleClass('sb-collapsed');
		if($('.fixed-menu').hasClass('sb-collapsed')) {
			$('#sidebar-collapse .fa').addClass('fa-angle-right').removeClass('fa-angle-left');
			state = 1;
		} else {
			$('#sidebar-collapse .fa').addClass('fa-angle-left').removeClass('fa-angle-right');
			state = 0;
		}
		$.ajax({
			type: 'POST',
			url: '/ajax/custom.php',
			data: {'update_sidebar' : true, 'sidebar_state' : state}
		});
	});
	
	$('.cl-toggle').click(function() {
		if($('.cl-vnavigation').css('display') != "block") {
			$('.cl-vnavigation').slideDown(400);
		} else {
			$('.cl-vnavigation').slideUp(400);
		}
	});
	
	//Textarea autosize
	$('textarea').autosize();
	
	//Datatable
	$(".dataTable").dataTable({
		"oLanguage": { 
			"oPaginate": {
				"sLast": "Viimane",
				"sFirst": "Esimene",
				"sNext": "Järgmine",
				"sPrevious": "Eelmine"							
			},
			"sSearch": "",
			"sZeroRecords": "Tulemused puuduvad!",
			"sLoadingRecords": "Palun oota - Laen tulemusi...",
			"sLengthMenu": "_MENU_",
			"sInfoEmpty": "Tulemused puuduvad"
		},
		"bInfo" : false
	});
	
	// Edit Modal
	$('table').on('click', 'td button.edit_news', function() {
		var src = $(this).attr('data-src');
		var nid = $(this).attr('id');
		$.ajax({
			beforeSend: function() {
				loader2.show();
			},
			method: 'POST',
			data: {'fnwid' : nid},
			url: '/ajax/fetch.php',
			success: function(data) {
				loader2.hide();
				$('#changeModal .modal-body').load(src);
				$('#changeModal').modal('show');
			}
		});
	});
	
	var live_table = $('#live_table').dataTable({
		"bDestroy": true,
		"bPaginate": false,
		"bInfo": false,
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": "/ajax/datatable.php",
		"aoColumns": [
			{ 				
				"mData": null,
				"fnCreatedCell": function ( nTd, sData, oData, iRow, iCol )  {
					$(nTd).addClass('notification notification-' + oData.deadlineColor)
				},
				"bSortable": false
			},
			{ "mData": "content", "bSortable": false },
			{ "mData": "deadline"},
			{ "mData": "author"}, 
			{ "mData": "labelColor", "bSortable": false },
			{ "mData": "date"}, 
			{ "mData": "id", "bSortable": false} 
		],
		"aoColumnDefs": [
		
			//TähtaegColor
			{
				aTargets: [0]
			},
			//Teade
			{
				aTargets: [1]
			},
			//Tähtaeg
			{
				sSortDataType: "dom-text",
				aTargets: [2],
				sClass: "fix-tcenter fix-valign-c"
			},
			//Autor
			{
				aTargets: [3],
				sClass: "fix-tcenter fix-valign-c"
			},
			//Grupp
			{ 
				aTargets: [4],
				sClass: "fix-tcenter fix-valign-c",
				"mRender": function ( url, type, full )  {
					return '<label class="label label-' + url + '">' + full.groupLabel + '</label>';
				}
				
			},
			//Lisatud 
			{
				aTargets: [5],
				sClass: "fix-tcenter fix-valign-c"
			},
			//Button
			{
				aTargets: [6],
				"mRender": function ( data, type, full ) {
					return '<button class="btn btn-success btn-xs edit_news" id="' + data + '" data-src="/ajax/fetch.php?fnwid=' + data + '">' + '<i class="fa fa-pencil"></i>' + '</button>';
				}
			}
		],
		"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
			$(nRow).addClass(aData.completedColor);
			//return nRow;
			
			
			
		}
	});
	
	setInterval( function () {
		live_table.fnDraw();
	}, 60000 );
	
	$('.dataTables_filter input').addClass('form-control').attr('placeholder','Otsing');
	$('.dataTables_length select').addClass('form-control');

	/*DateTime Picker*/
	$(".datetime").datetimepicker({
		icons: {
			time: "fa fa-clock-o",
			date: "fa fa-calendar",
			up: "fa fa-arrow-up",
			down: "fa fa-arrow-down"
		},
		useSeconds: false,
		sideBySide: true,
		language: 'et',
		use24hours: true
	});
	
	//Submenu Collapse
	$(".cl-vnavigation").delegate(".parent > a","click",function(e){
	$(".cl-vnavigation .parent.open > ul").not($(this).parent().find("ul")).slideUp(300, 'swing',function(){
	   $(this).parent().removeClass("open");
	});
	
	var ul = $(this).parent().find("ul");
	ul.slideToggle(300, 'swing', function () {
		var p = $(this).parent();
		if(p.hasClass("open")){
			p.removeClass("open");
		}else{
			p.addClass("open");
		}
		//$("#cl-wrapper .nscroller").nanoScroller({ preventPageScrolling: true });
	});
	e.preventDefault();
	});
	
	/*SubMenu hover */
	var tool = $("<div id='sub-menu-nav' style='position:fixed;z-index:9999;'></div>");
	
	function showMenu(_this, e){
		if(($("#cl-wrapper").hasClass("sb-collapsed") || ($(window).width() > 755 && $(window).width() < 963)) && $("ul",_this).length > 0){   
			$(_this).removeClass("ocult");
			var menu = $("ul",_this);
			if(!$(".dropdown-header",_this).length){
				var head = '<li class="dropdown-header">' +  $(_this).children().html()  + "</li>" ;
				menu.prepend(head);
			}
		
			tool.appendTo("body");
			var top = ($(_this).offset().top + 8) - $(window).scrollTop();
			var left = $(_this).width();
		
			tool.css({
				'top': top,
				'left': left + 8
			});
			tool.html('<ul class="sub-menu">' + menu.html() + '</ul>');
			tool.show();
		
			menu.css('top', top);
		}else{
			tool.hide();
		}
	}

	$(".cl-vnavigation li").hover(function(e){
		showMenu(this, e);
	},function(e){
		tool.removeClass("over");
		setTimeout(function(){
			if(!tool.hasClass("over") && !$(".cl-vnavigation li:hover").length > 0){
				tool.hide();
			}
		},500);
	});
        
	tool.hover(function(e){
		$(this).addClass("over");
	},function(){
		$(this).removeClass("over");
		tool.fadeOut("fast");
	});
        
        
	$(document).click(function(){
		tool.hide();
	});
	$(document).on('touchstart click', function(e){
		tool.fadeOut("fast");
	});
        
	tool.click(function(e){
		e.stopPropagation();
	});
     
	$(".cl-vnavigation li").click(function(e){
		if((($("#cl-wrapper").hasClass("sb-collapsed") || ($(window).width() > 755 && $(window).width() < 963)) && $("ul",this).length > 0) && !($(window).width() < 755)){
			showMenu(this, e);
			e.stopPropagation();
		}
	}); 

	//active class avab dropdowni
	$(".cl-vnavigation li ul li.active").each(function(){
		$(this).parent().show().parent().addClass("open");
	});
	//X-Editable -> Teadete muutmine
	$('#muudaAdmin a').editable({
		validate: function(value) {
			if (value === null || value === '') {
				return 'Tühju väljasid ei või olla!';
			}
		},
		url: '/ajax/inline_edit/post.php'
	});	
	
	$('#muudaDate a').editable({
		validate: function(value) {
			if (value === null || value === '') {
				return 'Tühju väljasid ei või olla!';
			}
		},
		type: 'combodate',
		url: '/ajax/inline_edit/date.php',
		ajaxOptions: {
			dataType: 'json'
		},
		success: function(value, response) {
			return {newValue: value};
		},
		display: function(value, newValue) {
			if(value.success) {
				$(this).html(value.result);
			}
		}
	});
	
	$('#muudaGrupp a').editable({
		validate: function(value) {
			if (value === null || value === '') {
				return 'Tühju väljasid ei või olla!';
			}
		},
		type: 'select',
		url: '/ajax/inline_edit/post.php',
		ajaxOptions: {
			dataType: 'json'
		},
		success: function(value, response) {
			return {newValue: value};
		},
		display: function(value, newValue) {
			if(value.success) {
				$(this).html(value.result);
			}
		}
	});

	
	// Sortimine -> cookie
	$('.deskSort').change(function() { 
		var sort_by = $('.deskSort option:selected').attr('arial-type');
		var value = $(this).val();		
		$.ajax({
			type: 'POST',
			url: '/ajax/custom.php',
			data: {'update_sorting' : true, 'sort_by' : sort_by, 'sort_value' : value},
		 success: function(){
				live_table.fnDraw();
			}
		});
	});
	
});