<?php

	class ldapClass { 
	    private $host;
	    private $username;
	    private $password;
	    private $domain;
	    public $ldap_connection;

	    function connectLDAP($host, $username, $password, $domain) {
	        $this->host = $host;
	        $this->username = $username; 
	        $this->password = $password;
	        $this->domain 	= $domain;
	        $this->ldap_connection = ldap_connect($this->host); //connnect ldap to host
	        
	        // We have to set this option for the version of Active Directory we are using.
			ldap_set_option($this->ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
			ldap_set_option($this->ldap_connection, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.
			$bind = @ldap_bind($this->ldap_connection, $this->domain.$this->username, $this->password);
			if($bind){ return TRUE; }
			return FALSE;
	    } 

	    function getLDAPData($dn, $filter, $attribute){

	    	$result = ldap_search($this->ldap_connection, $dn, $filter, $attribute);
	    	if (FALSE != $result){
	    		$data = array();
	    		$entries = ldap_get_entries($this->ldap_connection, $result);
	    		
	    		for ($x=0; $x<$entries['count']; $x++){
		        	$object = new stdClass();
		        	for ($i=0;$i<count($attribute);$i++){
		        		
		        		if(!empty($entries[$x][$attribute[$i]])){
		        			$object->$attribute[$i] = $entries[$x][$attribute[$i]][0];
		        		}
		        		
		        	}
		        	$data[] = $object;
		        }
		        
	    		ldap_unbind($this->ldap_connection);
	    		return json_encode($data);
	    	}
	    }
	} 

?>