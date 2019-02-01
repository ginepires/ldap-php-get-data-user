# ldap-php-get-data-user
this class will get data (json) in active directory [php]

HOW TO INCLUDE IT?

1 - include the class 
require_once('ldapClass.php');

2 - call the class
$ldapc = new ldapClass();

3 - call function to connect on server
$ldapc->connectLDAP($host,$username, $password, $domain) // note the variable domain must be like "domain\\"

4 - get result
example $dn = 'DC=domain,DC=com';
example $filter = (&(sn=*)) //first name *(all)
example $array('mail','sn', 'samaccountname', 'givenname', 'cn', 'telephonenumber', 'description', 'physicaldeliveryofficename') // list of attributes to retrieve
$result = $ldapc->getLDAPData($dn, $filter,$attribute);
