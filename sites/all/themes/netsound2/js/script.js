jQuery(function($){
	
	$('.feature-tab:not(:first)').parent().hide();
	$('a.tab:first').addClass('active');
	readpictureheight(0);	
	$('#topfeature').append('<ul class="page-selector"></ul>');
	
	var link = $('#topfeature a.tab');
	link.click(function(){

		
		$('a.tab').removeClass('active');
		
		$(this).addClass('active');
		
		id = link.index($(this));
		$('.feature-tab').parent().hide();
		$('.feature-tab:eq('+id+')').parent().show();
		//readpictureheight(id);
		return false;
	});
	// move buttons below
	link.each(function(i){
		$('.page-selector').append('<li></li>');
		$('.page-selector > li:last').append($(this));
	});
	
	function readpictureheight(page){
		return ;
		page = $('#topfeature .feature-tab:eq('+page+')');
		
			var pictures = page.find('.picture');
			highest = 0;
			pictures.each(function(j){
				height = parseInt($(this).height());
				if(height > highest){
					highest = height;
				}
			});
			pictures.height(highest);
			
		
	}
	
	$('.annullerknap').click(function(){
		window.parent.Lightbox.end();
		return false;
	});
	
	$('#user-login #edit-name').keyup(function(){
		if($(this).val().length > 9){
			jQuery.getJSON( '/getlibrary/'+$(this).val(),function(data){
				if(data.elib_library){
					$('#user-login #edit-library option[value='+data.elib_library+']').attr('selected','selected');
				}
			});
		}
	});
	
	
	
/*	pages = $('.top .pane-book');
	$('.top').after('<ul class="top-pager"></ul>');
	pages.each(function(i){
		if (i > 0){
			$(this).hide();
		}
		$('.top-pager').append('<li>'+$(this).children('h2.pane-title').text()+'</li>');
	});
	$('.top-pager li:eq(0)').addClass('active');
	
	
	$('.top-pager li').click(function(e){
     $(this).addClass('active');
		 pages.hide(); 
		 index = $('.top-pager li').index(this);
		 
		 newpage = pages[index];
		 newpage.show();
		 
		 
  });
  */
	
	
	
/*	$(".fivestar-widget-static").each(function(){
		var stars = parseInt($(this).text());
		var list = $(this).after('<ul class="rating"></ul>');
		$(this).remove();
		for(i = 0;i<stars;i++){
			list.append('<li>star</li>');
		}
	});*/
	

	$(".topmenu #ting-search-form .form-item-textfield label").inFieldLabels(); 
	
	
	 $('#ting-search-results').mousedown(function() {
		 //console.log('down');
		 Lightbox.initList();
		 
		 
    /*    $('.icons a').unbind('click').click(function(){
        	console.log('click');
 
//        	return false;
        });*/
    });


	 /*quirks */
	 
	 
	 
	 $('.view-faq .unit:even').before('<div class="line">').children('.inside2').css('padding-right','5px'); 
	 $('.view-faq .unit:odd').after('</div">').children('.inside2').css('padding-left','5px');

	 $('.view-faq .unit').each(function(){
		 link = $(this).find('div.tid');
		 $(this).find('div.tid').remove();
		 $(this).children('.inside2').append(link[0]);
	 });
	
});