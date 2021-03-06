<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 15:38
 * PHP version 7.
 */

namespace App\Controller;

//var_dump($_SESSION);

//var_dump($_GET);

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected Environment $twig;

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => !APP_DEV, // @phpstan-ignore-line
                'debug' => APP_DEV,
            ]
        );
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new DebugExtension());
    }
}
