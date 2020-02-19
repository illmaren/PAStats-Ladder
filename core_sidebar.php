<?

function loadsidebar($block){
	if (!file_exists('include/sidebar/'.$block.'.php'))
	{
		echo 'Error: The Sidebar file: "'.$block.'" is missing.<br>';
		exit;
	}
	else
	{	
		include_once 'include/sidebar/'.$block.'.php';
	}
}

?>