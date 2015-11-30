<?php
namespace Native5\Db;

class BaseDbDAO
{
    protected $queries;
    protected static $db;
    private static $initialized = false;

    public function __construct() {
        self::_initialize();
    }

    /**
     * loadQueries Set the name of the yaml file with sql queries indexed by query names
     * 
     * @param mixed $sqlQueriesFile Filesystem path to yaml file
     *
     * @access protected
     * @return void
     */
    protected function loadQueries($sqlQueriesFile) {
        // Read the sql queries file
        if (!file_exists($sqlQueriesFile))
            throw new \Exception("File with mysql queries not found at expected location: $sqlQueriesFile");

        if (!($this->queries = \Symfony\Component\Yaml\Yaml::parse(file_get_contents($sqlQueriesFile))))
            throw new \Exception("Could not parse yaml file with mysql queries: $sqlQueriesFile");
    }

    // ************** Private Functions Follow **************** //

    /**
     * _initialize  Initializes Illuminate Capsule database only once in a backend call
     * 
     * @static
     * @access private
     * @return void
     */
    private static function _initialize() {
        if (self::$initialized) {
            return true;
        }

        // Get database settings from config/settings.yml
        $dbConfig = $GLOBALS['app']->getConfiguration()->getRawConfiguration('database');

        self::$db = new \Illuminate\Database\Capsule\Manager;

        try {
            self::$db->addConnection(array(
                'driver'    => $dbConfig['type'],
                'host'      => $dbConfig['host'],
                'database'  => $dbConfig['name'],
                'username'  => $dbConfig['user'],
                'password'  => $dbConfig['password'],
                'charset'   => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix'    => ''
            ));

            // Set the event dispatcher used by Eloquent models... (optional)
            self::$db->setEventDispatcher(new \Illuminate\Events\Dispatcher(new \Illuminate\Container\Container));

            // Make this Capsule instance available globally
            self::$db->setAsGlobal();

            // Boot eloquent ORM
            self::$db->bootEloquent();
        } catch (\PDOException $e) {
            throw new \Exception("Could not connect to database. Message: ".$e->getMessage());
        }
        
        self::$initialized = true;
    }

}

