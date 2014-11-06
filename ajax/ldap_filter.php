<?php
include ('../../../inc/includes.php');

Session::checkRight("config", "w");

$authldap = new AuthLdap();
$authldap->getFromDB($_POST['value']);
$filter = "(".$authldap->getField("login_field")."=*)";
$ldap_condition = $authldap->getField('condition');
echo "(& $filter $ldap_condition)";
