<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require 'vendor/autoload.php';


$app = new \Slim\App;
$app->get('/', function (Request $req,  Response $res, $args = []) {
    $myvar1 = $req->getParam('myvar'); //checks both _GET and _POST [NOT PSR-7 Compliant]
    echo $myvar1;
    $myvar2 = $req->getParsedBody()['myvar']; //checks _POST  [IS PSR-7 compliant]
    $myvar3 = $req->getQueryParams()['myvar']; //checks _GET [IS PSR-7 compliant]
});
$app->run();

?>