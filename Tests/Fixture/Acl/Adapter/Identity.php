<?php
class Fixture_Acl_Identity implements Saros_Auth_Identity_Interface
{
	public function getIdentifier()
	{
		return 0;
	}

	// Get the value of the key from the identity
	public function __get($key)
	{
		return null;
	}
}
?>
