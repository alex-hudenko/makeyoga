<?php
require_once __DIR__.'/lib/silex.phar';
require_once __DIR__.'/config.php';

$app = new Silex\Application();
$app['debug'] = APP_DEBUG;
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/views',
    'twig.class_path' => __DIR__.'/lib/vendor/twig/lib',
));
