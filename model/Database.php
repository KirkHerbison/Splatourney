
<?php
class Database {
//    private static $dsn = 'mysql:host=localhost;dbname=splatourney';
//    private static $username = 'mgs_user';
//    private static $password = 'pa55word';
    private static $dsn = 'mysql:host=localhost:3308;dbname=splatourney';
    private static $username = 'root';
    private static $password = 'sesame';
    private static $db;

    private function __construct() {}

    public static function getDB () {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                     self::$username,
                                     self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                include('../view/database_error.php');
                exit();
            }
        }
        return self::$db;
    }
}
?>