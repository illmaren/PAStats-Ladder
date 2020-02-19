<?
$pageName = $url[1];
$action = $url[2];


$allowed = array(
	'home',
	'1on1',
	'2on2',
	'player',
	'playerlist',
	'stats',
	'login',
	'register',
	'forgot',
	'pwchange',
	'uberskill',
	'chat',
	'news',
	'forum',
	'admin',
	'ucp',
	'acp',
	'donate',
	'faq',
);

function saltPassword($password, $salt)
{
     return hash('sha256', $password . $salt);
}

if($pageName == ""){
$pageName = "home";
}
define('init_pages', true);


function loadclass($class){
	if (!file_exists('include/classes/class.'.$class.'.php'))
	{
		echo 'Error: The Class file: "'.$class.'" is missing.<br>';
		exit;
	}
	else
	{	
		include_once 'include/classes/class.'.$class.'.php';
	}
}

if (in_array($pageName, $allowed))
{
	if (!file_exists('include/pages/'.$pageName.'.php'))
	{
		echo 'Error: The page file is missing.';
	}
	else
	{	
		include_once 'include/pages/'.$pageName.'.php';
	}
}
else
{
	echo 'Error: Page not allowed.';
}
?>