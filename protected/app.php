<?php

require_once 'bootstrap.php';

$app->get('/', function () use ($app) {
	return $app['twig']->render('index.twig', array('rows' => Page::getHomePageData()));
});

$app->get('/page/{title}', function ($title) use ($app) {
	$page = Page::getPageDataByTitle($title);
	if (!$page) {
	    // 404
	}
	return $app['twig']->render('page.twig', array('page' => $page));
});

$app->run();

?>
