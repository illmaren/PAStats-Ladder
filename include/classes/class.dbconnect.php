<?
class db extends mysqli {
    public function __construct($dbconfig = null) {
			$dbconfig = array( 
				'dbhost' => 'localhost',
				'dbuser' => 'root',
				'dbpass' => 'clever01',
				'dbname' => 'game'
			);
        if (is_null($dbconfig) OR ! is_array($dbconfig))
            die('Ohne Zugangsdaten mach ich überhaupt nix!');
        @parent::__construct( 'p:'.$dbconfig['dbhost'], 
                                          $dbconfig['dbuser'], 
                                          $dbconfig['dbpass'], 
                                          $dbconfig['dbname']);
        if (mysqli_connect_errno()) {
            printf("<h4>Connect failed: %s</h4>\n", mysqli_connect_error());
            exit();
       }
	}
}

function escape($con, $escape){
return mysqli_real_escape_string($con , $escape);
}

function getoptionvalue($con, $ask)
{
    $row = $con->query("SELECT * FROM options WHERE name = '$ask'")->fetch_array();
    return $row["value"];
}

function getright($con, $ask)
{
    $row = $con->query("SELECT rights FROM user WHERE id = '$ask'")->fetch_array();
    return $row["rights"];
}