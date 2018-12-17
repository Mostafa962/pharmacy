<?php 
/**
* 
*/
class DBConnect  
{
	// Holds a refence to the Database connction handler
	private static $dbh;
	//set the constructor to private to prevent instantiation
    private function __construct (){}
	/*connect to database
	Singleton design pattern,
    get only one single instance of the class*/
    public static function DatabaseConnect (){
        try{

            if (null === self::$dbh){
                self::$dbh =new PDO('mysql://hostname=' . DB_HOST . ';dbname=' . DB_NAME,DB_USER);
            }
            $options = array( PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', );
            //rovide a means for standardizing statements across database engines.
             self::$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
            //change error mode from default  PDO::ERRMODE_SILENT,
            self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$dbh;
        }
        catch (PDOException $e) {
            echo 'Failed: ' . $e->getMessage();
         }
    } 
}