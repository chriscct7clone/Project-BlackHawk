<?php

/*
* The class database provides a basic Mysql connection (non-PDO)
* Almost ready for PDO migration if needed
* @author Chris Christoff
* @name database
* @version 0.0.1
* @package Project-BlackHawk
* @link http://www.futuregencode.com/blackhawk
*/
class database
{

    /*
     * Constructor
     */
    function __construct()
    {
    }

    /*
    * Establish a database connection
    *
    * @param string $db Database name
    * @param string $user Database user
    * @param string $pass Password for database access
    * @param string $host Database host
    * @return bool
    */
    function connect($db_name, $db_user, $db_pass, $db_host="localhost")
    {

	//mysql
	//$db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

	$conn = mysql_connect($db_host,$db_user,$db_pass);
        $db_check = mysql_select_db($db_name);
        if($db_check)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*
     * Wrap mysql_query function
     *
     * @param string $str SQL search query
     * @return bool
     */
    function query($str)
    {
    	return mysql_query($str);
    }
}
?>