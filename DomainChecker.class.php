<?php
class DomainChecker {

	var $domain_ok = false;
	var $dns_ok = false;
	var $url = false;
	var $page_up = false;
	var $debug = false;

	function _set($var,$val){
		$this->$var = $val;
	return $this;
	}


	function validate(){
		if($this->debug){ echo "inside<br/>"; }
		if(!$this->url){ return $this; }
		if($this->debug){ echo "set<br/>"; }
		$this->url = strtolower(trim($this->url));
		if($this->debug){ echo "trimmed<br/>"; }
		$parsed = parse_url($this->url);
		if($this->debug){ echo "parsed<br/>"; }
		$domain = (!empty($parsed['host']))?$parsed['host']:$parsed['path'];
		if($this->debug){ echo "domain parsed<br/>"; }
		if(empty($domain)){ return $this; }
		if($this->debug){ echo "not empty<br/>"; }
		$split = explode('.',$domain);
		if($this->debug){ echo "split<br/>"; }
		$domain = $split[(count($split)-2)].".".$split[(count($split)-1)];
		if($this->debug){ echo "re-engineered<br/>"; }
		$this->dns_ok = checkdnsrr($domain,"A");
		if($this->debug){ echo "checkeddns<br/>"; }
		if($this->dns_ok){
			if($this->debug){ echo "dnsok<br/>"; }
			$html = file_get_contents('http://'.$domain);
			if($this->debug){ echo "filegetcontents<br/>"; }
			if(!empty($html)){
			if($this->debug){ echo "html not empty<br/>"; }
				$this->page_up = true;
			}
		}
		if($this->debug){ echo "outside ifv"; }
		if($this->page_up && $this->dns_ok){
			if($this->debug){ echo "dns OK<br/>"; }
			$this->domain_ok = true;
		}
		$this->domain = $domain;
		if($this->debug){ echo "ok<br/>"; }
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
