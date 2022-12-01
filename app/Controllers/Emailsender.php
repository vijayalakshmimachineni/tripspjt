<?php
require_once('vendor/autoload.php');
define('MY_APIKEY', '3E38D532575A4F3F0AD0527F27069BA9A94DD0FB04328DCD7B51F0730437D962F2438A67983ACDA6F4082CD2E9F119FE');

$config = ElasticEmail\Configuration::getDefaultConfiguration()
        ->setApiKey('X-ElasticEmail-ApiKey', MY_APIKEY);
 
$apiInstance = new ElasticEmail\Api\EmailsApi(
    new GuzzleHttp\Client(),
    $config
);
 
$email = new \ElasticEmail\Model\EmailMessageData(array(
    "recipients" => array(
        new \ElasticEmail\Model\EmailRecipient(array("email" => "vijayalakshmi.m@siriinnovations.com"))
    ),
    "content" => new \ElasticEmail\Model\EmailContent(array(
        "body" => array(
            new \ElasticEmail\Model\BodyPart(array(
                "content_type" => "HTML",
                "content" => "My content"
            ))
        ),
        "from" => "vijayalakshmi.m@siriinnovations.com",
        "subject" => "My Subject"
    ))
));
 
try {
    $apiInstance->emailsPost($email);
} catch (Exception $e) {
    echo 'Exception when calling EE API: ', $e->getMessage(), PHP_EOL;
}




?>