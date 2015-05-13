$('.replicate-link').live('click', function(event) {
	processReplicateLink(this);
});

function processReplicateLink ( link ) {

	var origin = $(link).attr("data-replicate-origin");
	var end = $(link).attr("data-replicate-end");
	var reload = $(link).attr("data-replicate-reload");
        
	if (origin && end) {

		if (! $(link).hasClass('replicate-link-done') ) {

			$.get( mw.util.wikiScript(), {
				format: 'json',
				action: 'ajax',
				rs: 'ReplicatePage::executeReplicate',
				rsargs: [origin, end] // becomes &rsargs[]=arg1&rsargs[]=arg2...
			}, function(data) {

				$(link).addClass("replicate-link-done");
                                var htmlbit = "<span class='replicate-link-fade'>"+data+"</span>";
				$(link).parent().append(htmlbit);

                                $('.replicate-link-done').fadeIn().delay(1000).fadeOut();
                               
				if (reload == 1) {
					window.setTimeout('location.reload()', 1500);	
				}

				else {
 
                                	setInterval(function() {
                                        	if ($('.replicate-link-fade').css('visibility') == 'hidden') {
                                                	$('.replicate-link-fade').css('visibility', 'visible');
                                        	} else {
                                        	$('.replicate-link-fade').css('visibility', 'hidden');
                                        	}    
                               		}, 500);
                                
                                	$('.replicate-link-fade').fadeIn().delay(3000).fadeOut();

                                }
			});
		}

	}
}
