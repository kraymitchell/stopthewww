<?php

if(isset($_POST['url'])){

	include('DomainChecker.class.php');

	$DomainChecker = new DomainChecker();
	$DomainChecker->_set('url',$_POST['url'])->validate();

	echo json_encode(array(
			'state'=>$DomainChecker->domain_ok,
			'page_up'=>$DomainChecker->page_up,
			'www_up'=>$DomainChecker->www_up,
			'domain'=>$DomainChecker->domain,
			'redirected'=>$DomainChecker->redirected,
			'redirected_correctly'=>$DomainChecker->redirected_correctly
		));
die();
}

?>
<form class="uk-form" id="checka_form" method="post" action="">
<div class="uk-grid">
<div class="uk-width-medium-2-3">
<input name="url" value="" class="uk-form-large uk-width-medium-1-1" type="text" placeholder="http://www.yourdomain.com" id="domain_input">
</div>
<div class="uk-width-medium-1-3">
<button class="uk-button uk-button-success uk-button-large uk-button-expand" type="submit">Check  It</button>
</div>
</div>
</form>	
