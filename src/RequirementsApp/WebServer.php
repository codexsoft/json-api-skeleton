<?php

namespace RequirementsApp;

use CodexSoft\JsonApi\AbstractWebServer;
use Symfony\Component\Routing\RouteCollectionBuilder;

class WebServer extends AbstractWebServer
{

    /**
     * @param RouteCollectionBuilder $routes
     *
     * @throws \Symfony\Component\Config\Exception\LoaderLoadException
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        //die($this->getProjectDir().'/src/');
        $routes->import($this->getProjectDir().'/src/', '/', 'annotation');

        //$confDir = $this->getConfigDir();
        //$routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
        //$routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
        //$routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
    }

}
