<?php
 
//access the Google Users Service
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;
use google\appengine\api\cloud_storage;

# Looks for current Google account session
$user = UserService::getCurrentUser();
if (!$user) {
  header('Location: ' . UserService::createLoginURL($_SERVER['REQUEST_URI']));
  return;
}

$userEmail = 'Hello, ' . htmlspecialchars($user->getEmail());
?>

<html>
<head>
<title>A Tree About Me - Genealogy for the Modern Family</title>
<link rel="stylesheet" type="text/css" href="styles/main.css">
</head>

<body>

	<div id="container">
    	<div id="header">
       		<h2>A Tree About Me</h2>
    	</div>
		<div id="content">
<?

//check if user has uploaded a file
$filename = 'gs://#default#/' . $user->getEmail() . '/' . "root";

if( file_exists ( $filename ) )
{
	echo file_get_contents( $filename );
}
else
{
	echo '<br/>File does not exist';
	file_put_contents( $filename, '
		{
			"id": "root",
			"fname": 
			"parents": [],
			"spouse": [],
			"children": [],
			"level": 0
		}');
}
?>
		</div>
		
		<div id="sidebar">
			sidebar content here
			<br/>
		</div>
	
		<div id="footer">
			(c) 2015 a tree about me - amrita gupta & saumya gurbani
		</div>
	</div>
	
	<div class="addnode_panel">
		<br/><br/>
		<a class="addnode-btn" href="#">+</a>
	</div>
	
	<div class="logout_panel">
		<br/><br/>
		<a class="logout-btn" href="<?php echo UserService::createLogoutUrl($_SERVER['REQUEST_URI']); ?>"><i>x</i></a>
	</div>
</body>
</html>
