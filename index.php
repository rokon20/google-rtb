<?php

// echo "Hello, world! This is PHP ". PHP_VERSION . "<hr>";

// Read the JSON data from the request body
$jsonData = file_get_contents('php://input');

// Decode the JSON data into an associative array
$requestData = json_decode($jsonData, true);

// Check if decoding was successful
if ($requestData === null && json_last_error() !== JSON_ERROR_NONE) {
    // Handle JSON decoding error
    die('Error decoding JSON data');
}

require_once("./helper.php");

// Define the json data folder path
$folderPath = "json_data/";

// Read bid request data from bid request JSON file
// $bidRequestFile = $folderPath . 'bid_request.json';
// $bidRequestData = readJsonFile($bidRequestFile);

// Retrieve bid request data from the incoming payload
$bidRequestData = $requestData;

// Read campaign data from campaigns JSON file
$campaignsFile = $folderPath . 'campaigns.json';
$campaignData = readJsonFile($campaignsFile);

// Select the most suitable campaign
$selectedCampaign = selectCampaign($bidRequestData, $campaignData);

// Generate banner campaign response
$bannerResponse = [];
if ($selectedCampaign) {
    $bannerResponse = [
        'id' => $bidRequestData['id'],
        'bid_price' => $selectedCampaign['price'],
        'ad_id' => $selectedCampaign['code'],
        'creative_id' => $selectedCampaign['creative_id'],
        'campaign_name' => $selectedCampaign['campaignname'],
        'advertiser' => $selectedCampaign['advertiser'],
        'creative_type' => $selectedCampaign['creative_type'],
        'image_url' => $selectedCampaign['image_url'],
        'landing_page_url' => $selectedCampaign['url'],
    ];

    $msg = "Congratulations, suitable campaign found for the bid request!";
} else {
    $msg = "Sorry, no suitable campaign found for the bid request.";
}

$finalResponse = array(
    "message" => $msg,
    "campaign_details" => $bannerResponse
);

echo json_encode($finalResponse, JSON_PRETTY_PRINT);
