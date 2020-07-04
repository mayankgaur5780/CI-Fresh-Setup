<?php
/**
 * Capsule setting manager for Illuminate/database
 */
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as CapsuleManager;
use Illuminate\Events\Dispatcher;

class Capsule extends CapsuleManager
{
    public function __construct()
    {
        parent::__construct();

        $this->addConnection(array(
            'driver' => 'mysql',
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => getenv('DB_CHAT_SET'),
            'collation' => getenv('DB_COLLATION'),
            'prefix' => getenv('DB_PREFIX'),
        ), "default");

        $this->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $this->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->bootEloquent();
    }
}
