<?php
  /**
  * This file will give an understanding of the standard php
  * authentication system
  *
  * Index Page: Welcome $username/ Guest
  *
  * Login Page: Prompt for username/password
  *
  * Proccess Page: Check if username/password is valid
  * 	If not, return an invalid result
  * 	If yes, Store the identity in the session
  *
  * Our way
  * Initilize an adapter and storage
  *	Index Page:
  * 	$auth = Saros_Auth::getInstance()
  * 	$auth->setAdapter($adapter);
  * 	$auth->setStorage($storage);
  *
  *		echo "Welcome "
  * 	if ($auth->hasIdentity())
  * 		echo $auth->getIdentity(); // This could be an object?
  * 	else
  * 		echo "Guest";
  *
  * Login Page: Prompt as usual
  *
  * Process Page:
  * 	$auth = Saros_Auth::getInstance();
  * 	$adapter = new Adapter($blah1, $blah2, $blah3);
  * 	$auth->setAdapter($adapter);
  * 	$auth->setStorage($storage);
  *
  * 	$result = $auth->authenticate();
  * 		... $adapter->authenticate();
  * 			if that is a success, then store the identity in storage
  * 			return $result;
  * 	if($result->getCode() == Saros_Auth_Result::SUCCESS)
  * 		redirect to index
  * 	else
  * 		redirect to login
  *
  * LogOut page:
  *     $auth = Saros_Auth::getInstance();
  * 	$adapter = new Adapter($blah1, $blah2, $blah3);
  * 	$auth->setAdapter($adapter);
  * 	$auth->setStorage($storage);
  *
  * 	$auth->end();
  *
  *
  */

?>
