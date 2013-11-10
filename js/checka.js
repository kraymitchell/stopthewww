(function($) {

$(document).ready(function(){
	$('.goodtogo').hide();
	$('#checka_form').on('submit',function(e){
		$('.goodtogo').hide();// cover the case of submitting multiple domains
		$('#working_animation').show();// ID of the working animation to show.
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "check.php",
			dataType: 'JSON',
			data: { url: $('#domain_input').val() }
		}).done(function( response ) {
			$('#working_animation').hide();// ID of the working animation to hide
			if(response.dns_ok == true && response.page_up == true){
				$('.uk-text-success').slideDown(500);
			} else if(response.dns_ok == true && response.page_up == false){
				$('.uk-text-warning').slideDown(500);
			} else if(response.dns_ok == false && response.page_up == false){
				$('.uk-text-danger').slideDown(500);
			}
		});
	});
});

})(jQuery);
