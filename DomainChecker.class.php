<?php
class DomainChecker {

	var $domain_ok = false;
	var $dns_ok = false;
	var $url = false;
	var $page_up = false;

	function _set($var,$val){
		$this->$var = $val;
	return $this;
	}


	function validate(){

		if(!$this->url){ return $this; }

		$this->url = strtolower(trim($this->url));

		$parsed = parse_url($this->url);

		$domain = (!empty($parsed['host']))?$parsed['host']:$parsed['path'];
		if(empty($domain)){ return $this; }

		$split = explode('.',$domain);
		$domain = $split[(count($split)-2)].".".$split[(count($split)-1)];

		$this->dns_ok = checkdnsrr($domain,"A");

		if($this->dns_ok){

			$html = file_get_contents('http://'.$domain);
			if(!empty($html)){
				$this->page_up = true;
			}
		}

		if($this->page_up && $this->dns_ok){
			$this->domain_ok = true;
		}
		$this->domain = $domain;

	return $this;
	}

	function dd($a){
		echo "<pre>";
		if(!is_array($a)){
			var_dump($a);
		} else {
			print_r($a);
		}
	die();
	}
}
