jQuery(function(){
	
	
	$('.feature-tab:not(:first)').hide();
		
	$('#topfeature').append('<ul class="page-selector"></ul>');
	
	var link = $('#topfeature a.tab');
	link.click(function(){

		id = link.index($(this));
		$('.feature-tab').hide();
		$('.feature-tab:eq('+id+')').show();
		return false;
	});
	// move buttons below
	link.each(function(i){
		$('.page-selector').append('<li></li>');
		$('.page-selector > li:last').append($(this));
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
	

	$(".form-item-textfield label").inFieldLabels(); 
	
	
});