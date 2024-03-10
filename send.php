<?php

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

require __DIR__ . "/vendor/autoload.php";

$number = $_POST["number"];
$message = $_POST["message"];

if ($_POST["provider"] === "infobip") {


$base_url = "w15xjr.api.infobip.com";
$api_key = "a612948d1d57b260711727953336c1c9-4d06adb8-8ea2-4ffd-9ae0-de8a112b13f4";
$configuration = new Configuration(host: $base_url, apiKey: $api_key);
$api = new SmsApi(config: $configuration);

$destination = new SmsDestination(to: $number);

$message = new SmsTextualMessage(
    destinations: [$destination],
    text: $message,
    from: "daveh"
);

$request = new SmsAdvancedTextualRequest(messages: [$message]);

$response = $api->sendSmsMessage($request);
} else { echo "Invalid provider!"; exit(); }

echo "Message sent.";