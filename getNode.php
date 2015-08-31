<?php

//returns a JSON object of a single node in the tree, specified by the ID
//object SYNTAX:
//		msg:	a string consisting of the message the server is sending back
//		node:	the Node object itself

//make sure we have the user logged in
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;

# Looks for current Google account session
$user = UserService::getCurrentUser();
if (!$user) {
  header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
  return;
}

//make sure we have an ID variable passed
if(!isset($_GET['id'])) {
	$id = "root";	//use "root" as the initial ID
}
else {
	$id = $_GET["id"];	//currently use GET, but eventually switch to POST
}

//get the file contents of the json object specified by the user's tree and the ID
$filename = 'gs://#default#/' . $user->getEmail() . '/' . $id;

echo '{';

if( file_exists ( $filename ) )
{
	echo '"msg" : 1, "node": ';
	echo file_get_contents( $filename );		//output the JSON object
	echo '}';
}
else
{
	echo '"msg" : 0}';
}

?>