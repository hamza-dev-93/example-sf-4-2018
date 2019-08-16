<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

class Fetcher
{
    private $defaultURL;
    private $container;

    /**
     * Class constructor.
     */
    public function __construct(ContainerInterface $container, $defaultURL)
    {
        // var_dump($defaultURL);
        $this->defaultURL = $defaultURL;
        $this->container = $container;
    }

    public function get($url){

        if($url === $this->defaultURL) return false;

        $uploads_dir = $this->container->getParameter('defaultURL');
        // var_dump($uploads_dir);
        // ! get the result from the api
        $result = file_get_contents($url);
        return \json_decode($result, true);

    }

    
}