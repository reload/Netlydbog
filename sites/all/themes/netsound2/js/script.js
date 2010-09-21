jQuery(function($){
	
	//$('.view-faq .unit:even').before('<span style="margin:5px;background:red" class="clear-block">');//.children('.inside2').css('padding-right','5px'); 
	//$('.view-faq .unit:odd').after('</span>');//.children('.inside2').css('padding-left','5px');

	$('.view-faq .unit').each(function(i){
		//if(console){
			//console.log(i%2);
		//}
		if(!(i%2)){
			$('.view-faq .view-content').append('<div class="line clear-block"></div>');
			$(this).children('.inside2').css('padding-right','5px'); 
		}
		else{
			$(this).children('.inside2').css('padding-left','5px');
		}
		$('.view-faq .view-content div.line:last').append($(this));
	});
	
	
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
	
	$('#user-login #edit-name').blur(function(){
	//	if($(this).val().length > 9 && $(this).val().length < 11){
			jQuery.getJSON( '/getlibrary/'+$(this).val(),function(data){
				if(data.elib_library){
					$('#user-login #edit-library option[value='+data.elib_library+']').attr('selected','selected');
				}
			});
//		}
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
	 	 
	 $('.view-faq .unit').each(function(){
		 link = $(this).find('div.tid');
		 $(this).find('div.tid').remove();
		 $(this).children('.inside2').append(link[0]);
	 });
	 
	var kill = false;
	function lookupSelector(){
		if(kill){
			return false;
		}
		setTimeout(function(){
			if($('.sort-by-selector').length > 0){
				onChangeRedirect();
				kill = true;
			}
			lookupSelector();
		},100);
	}
	lookupSelector();
	
	function onChangeRedirect(){
		
		var url = location.href;
		var parts = url.split('#');
		var cleanurl = parts[0];
		var fragment = parts[1];
		var parts = url.split('=');
		var sort = parts[1];
		
		if(fragment){
			$('.sort-by-selector').find('option[value='+sort+']').attr('selected','selected');
		}
		
		$('.sort-by-selector').change(function(){
			var value = $(this).find('option:selected').val();    
			location.href = cleanurl+'#sort='+value;
			
			setTimeout(function(){window.location.reload()},100);
		});
		
	} 
	 
	// $('.sort-by-selector').change(onChangeRedirect);
	
});