<?php

namespace Abram\Odbc;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection as IlluminateConnection;

class ODBCServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        IlluminateConnection::resolverFor('odbc', function(
            $connection,
            $database,
            $prefix,
            $config
        ){
            return new ODBCConnection(
                $connection,
                $database,
                $prefix,
                $config
            );
        });

        $this->app->bind('db.connector.odbc', function ($app) {
            return new ODBCConnector();
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);
        Model::setEventDispatcher($this->app['events']);
    }
}
