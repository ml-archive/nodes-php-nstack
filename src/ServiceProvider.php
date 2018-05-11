<?php

namespace Nodes\NStack;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Nodes\NStack\Providers\NStackProvider;
use Nodes\NStack\Exceptions\MissingCredentialsException;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * boot
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @return void
     */
    public function boot()
    {
        $this->publishGroups();
    }

    /**
     * register
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @return void
     */
    public function register()
    {
        $this->registerNStackProvider();
    }

    /**
     * publishGroups
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access protected
     * @return void
     */
    protected function publishGroups()
    {
        // Config files
        $this->publishes([
            __DIR__ . '/../config/nstack.php' => config_path('nodes/nstack.php'),
        ], 'config');
    }

    /**
     * registerPushProvider.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return void
     */
    protected function registerNStackProvider()
    {
        $this->app->singleton('nodes.nstack', function () {

            $credentials = config('nodes.nstack.credentials');

            if (empty($credentials['appId']) || empty($credentials['restKey'])) {
                throw new MissingCredentialsException('Missing NStack credentials');
            }

            $provider = new NStackProvider($credentials['appId'], $credentials['restKey']);

            return $provider;
        });

        $this->app->bind(NStackProvider::class, function ($app) {
            return $app['nodes.nstack'];
        });
    }
}
