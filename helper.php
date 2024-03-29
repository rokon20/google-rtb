<?php

// Function to print the contents of an array in a structured format
function printArray($data) {
    echo "<pre>";
        print_r($data);
    echo "</pre>";
}


// Function to read JSON data from a file
function readJsonFile($filename) {
    // Read JSON file
    $jsonData = file_get_contents($filename);

    // Decode JSON data into a PHP array and return
    return json_decode($jsonData, true);
}


// Function to get Alpha-3 country code from country name
function getAlpha3CountryCode($countryName) {
    $alpha3CountryCodes = readJsonFile('json_data/country_codes.json');

    $countryCode = array_search($countryName, $alpha3CountryCodes);

    return $countryCode;
}


// Function to get country name from Alpha-3 country code
function getCountryNameFromAlpha3Code($countryCode) {
    $alpha3CountryCodes = readJsonFile('json_data/country_codes.json');

    $countryName = isset($alpha3CountryCodes[$countryCode]) ? $alpha3CountryCodes[$countryCode] : "";

    return $countryName;
}

/**
 * Selects the most suitable campaign based on bid request parameters.
 *
 * @param array $bidRequestData The bid request data.
 * @param array $campaignData The campaign data.
 * @return array|null The selected campaign or null if none matches.
 */
function selectCampaign($bidRequestData, $campaignData) {
    $selectedCampaign = null;
    $maxBidPrice = 0;

    foreach ($campaignData as $campaign) {
        // Check if campaign is compatible with bid request parameters
        if (isCampaignCompatible($bidRequestData, $campaign)) {
            // Check if campaign bid price is higher than current max bid price
            if ($campaign['price'] > $maxBidPrice) {
                $selectedCampaign = $campaign;
                $maxBidPrice = $campaign['price'];
            }
        }
    }

    return $selectedCampaign;
}

/**
 * Checks if a campaign is compatible with bid request parameters.
 *
 * @param array $bidRequestData The bid request data.
 * @param array $campaign The campaign data.
 * @return bool Whether the campaign is compatible or not.
 */
function isCampaignCompatible($bidRequestData, $campaign) {
    return (
        isDeviceOsCompatible($bidRequestData, $campaign)
        && isDeviceMakeCompatible($bidRequestData, $campaign)
        && isCountryCompatible($bidRequestData, $campaign)
        && isAppNameCompatible($bidRequestData, $campaign)
    );
}

/**
 * Checks if the device OS of a campaign is compatible with bid request parameters.
 *
 * @param array $bidRequestData The bid request data.
 * @param array $campaign The campaign data.
 * @return bool Whether the device OS is compatible or not.
 */
function isDeviceOsCompatible($bidRequestData, $campaign) {
    $os = strtolower($bidRequestData['device']['os']);
    return in_array($os, array_map('strtolower', explode(',', $campaign['hs_os'])));
}

/**
 * Checks if the device make of a campaign is compatible with bid request parameters.
 *
 * @param array $bidRequestData The bid request data.
 * @param array $campaign The campaign data.
 * @return bool Whether the device make is compatible or not.
 */
function isDeviceMakeCompatible($bidRequestData, $campaign) {
    $deviceMake = strtolower($bidRequestData['device']['make']);
    if ($campaign['device_make'] === 'No Filter') {
        return true;
    }
    return in_array($deviceMake, array_map('strtolower', explode(',', $campaign['device_make'])));
}

/**
 * Checks if the country of a campaign is compatible with bid request parameters.
 *
 * @param array $bidRequestData The bid request data.
 * @param array $campaign The campaign data.
 * @return bool Whether the country is compatible or not.
 */
function isCountryCompatible($bidRequestData, $campaign) {
    $countryName = getCountryNameFromAlpha3Code($bidRequestData['device']['geo']['country']);
    return in_array($countryName, explode(',', $campaign['country']));
}

/**
 * Checks if the app name of a campaign is compatible with bid request parameters.
 *
 * @param array $bidRequestData The bid request data.
 * @param array $campaign The campaign data.
 * @return bool Whether the app name is compatible or not.
 */
function isAppNameCompatible($bidRequestData, $campaign) {
    if ($campaign['app_name'] === null || $bidRequestData['app']['name'] === null) {
        return true;
    }
    return in_array($bidRequestData['app']['name'], explode(',', $campaign['app_name']));
}
