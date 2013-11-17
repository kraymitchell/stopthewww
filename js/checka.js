(function($) {

$(document).ready(function(){
	// reset elements
	$('#working_animation').hide();
	$('.goodtogo').hide();

	$('#checka_form').on('submit',function(e){
		e.preventDefault();
		if(!$('#domain_input').val()){
		return;
		}
		$('.goodtogo').hide();// cover the case of submitting multiple domains
		$('#working_animation').show();// ID of the working animation to show.
		$.ajax({
			type: "POST",
			url: "check.php",
			dataType: 'JSON',
			data: { url: $('#domain_input').val() }
		}).done(function( response ) {
			$('#working_animation').hide();// ID of the working animation to hide
			if(response.redirected == true && response.redirected_correctly == true){
				$('.uk-text-success').slideDown(500);
			} else if(response.redirected == true && response.redirected_correctly == false){
				$('.uk-text-warning').slideDown(500);
			} else if(response.redirected == false && response.redirected_correctly == false){
				$('.uk-text-danger').slideDown(500);
			}
		});
	});
});

})(jQuery);
