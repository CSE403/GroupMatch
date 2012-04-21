<?php
namespace Fixture\Acl\Adapter;

class Identity implements \Saros\Auth\Identity\IIdentity
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
