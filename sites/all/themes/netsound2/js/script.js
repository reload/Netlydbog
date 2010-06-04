jQuery(function(){
	
	
	$('.feature-tab:not(:first)').hide();
	$('a.tab:first').addClass('active');
	readpictureheight(0);	
	$('#topfeature').append('<ul class="page-selector"></ul>');
	
	var link = $('#topfeature a.tab');
	link.click(function(){

		
		$('a.tab').removeClass('active');
		
		$(this).addClass('active');
		
		id = link.index($(this));
		$('.feature-tab').hide();
		$('.feature-tab:eq('+id+')').show();
		readpictureheight(id);
		return false;
	});
	// move buttons below
	link.each(function(i){
		$('.page-selector').append('<li></li>');
		$('.page-selector > li:last').append($(this));
	});
	
	function readpictureheight(page){
		
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
	

	$(".form-item-textfield label").inFieldLabels(); 
	
	
});