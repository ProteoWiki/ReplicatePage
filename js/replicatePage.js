/*global $ document jQuery console mw window alert location setInterval */

(function($) {

	$( document ).on( "click", ".replicate-link", function() {
		processReplicateLink(this);
	});

}( jQuery ) );

function processReplicateLink ( link ) {

	var source = $(link).attr("data-replicate-source");
	var target = $(link).attr("data-replicate-target");
	var reload = $(link).attr("data-replicate-reload");
        
	if ( source && target ) {

		if (! $(link).hasClass('replicate-link-done') ) {

			var param = {};
			param['format'] = 'json';
			param['action'] = 'replicatepage';
			param['source'] = source;
			param['target'] = target;

			var posting = $.get( mw.config.get( 'wgScriptPath' ) + "/api.php", param );
			posting.done(function( data ) {
				$(link).addClass("replicate-link-done");
                var htmlbit = "<span class='replicate-link-fade'>"+data+"</span>";
				$(link).parent().append(htmlbit);

				$('.replicate-link-done').fadeIn().delay(1000).fadeOut();
                               
				if (reload) {
					window.setTimeout('location.reload()', 1500);
				}

				else {
					setInterval(function() {
							if ( $('.replicate-link-fade').css('visibility') === 'hidden') {
								$('.replicate-link-fade').css('visibility', 'visible');
							} else {
								$('.replicate-link-fade').css('visibility', 'hidden');
							}    
					}, 500);
				
					$('.replicate-link-fade').fadeIn().delay(3000).fadeOut();
				}
			})
			.fail( function( data ) {
				alert("Error!");
			});
		}

	}
}
