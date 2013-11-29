<?php
class DomainChecker {

	var $domain_ok = false;
	var $dns_ok = false;
	var $url = false;
	var $page_up = false;
	var $redirected = false;
	var $redirected_correctly = false;
	var $www_up = false;

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
		$this->domain = $split[(count($split)-2)].".".$split[(count($split)-1)];

		$this->dns_ok = checkdnsrr($this->domain,"A");

		if($this->dns_ok){ // check if primary is up

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->domain);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$out = curl_exec($ch);

			$out = str_replace("\r", "", $out);
			$headers_end = strpos($out, "\n\n");
			if( $headers_end !== false ) {
				$out = substr($out, 0, $headers_end);
			}
			$headers = explode("\n", $out);

			if( strpos($headers[0], '200') !== false){
				$this->page_up = true;
			}
			curl_close($ch);
		}
		if($this->page_up){ // check if the www subdomain is up
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://www.".$this->domain);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$out = curl_exec($ch);

			$out = str_replace("\r", "", $out);
			$headers_end = strpos($out, "\n\n");
			if( $headers_end !== false ) {
				$this->www_up = true;
				$out = substr($out, 0, $headers_end);
			}
			$headers = explode("\n", $out);
			if( strpos($headers[0], '301') !== false){
				$this->redirected_correctly = true;
			}
			curl_close($ch);
		}

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
