# Test Cases

### Test Case 1: Bid Request Matches a Campaign with the Highest Bid Price

**Description:** Used the provided bid request JSON and campaign array. The script successfully matched the bid request with a campaign that had the highest bid price.

**Actual Response:**
```json
{
    "message": "Congratulations! A suitable campaign has been found for the bid request.",
    "campaign_details": {
        "id": "myB92gUhMdC5DUxndq3yAg",
        "bid_price": 0.1,
        "ad_id": "118965F12BE33FB7E",
        "creative_id": 167629,
        "campaign_name": "Test_Banner_13th-31st_march_Developer",
        "advertiser": "TestGP",
        "creative_type": "1",
        "image_url": "https://s3-ap-southeast-1.amazonaws.com/elasticbeanstalk-ap-southeast-1-5410920200615/CampaignFile/20240117030213/D300x250/e63324c6f222208f1dc66d3e2daaaf06.png",
        "landing_page_url": "https://adplaytechnology.com/"
    }
}
```

### Test Case 2: Bid Request Matches Multiple Campaigns, Script Selects the One with the Highest Bid Price

**Description:** Added a new campaign to the provided campaign JSON data. The bid request matched multiple campaigns, but the script selected the one with the highest bid price.

**Actual Response:**
```json
{
    "message": "Congratulations! A suitable campaign has been found for the bid request.",
    "campaign_details": {
        "id": "myB92gUhMdC5DUxndq3yAg",
        "bid_price": 0.15,
        "ad_id": "118965F12BE33FB7E_01",
        "creative_id": 167629,
        "campaign_name": "Test_Banner_By_Dev_01",
        "advertiser": "TestRobi",
        "creative_type": "1",
        "image_url": "https://s3-ap-southeast-1.amazonaws.com/elasticbeanstalk-ap-southeast-1-5410920200615/CampaignFile/20240117030213/D300x250/e63324c6f222208f1dc66d3e2daaaf06.png",
        "landing_page_url": "https://adplaytechnology.com/"
    }
}
```

### Test Case 3: Bid Request Doesn't Match Any Campaign

**Description:** Changed the payload's country in the bid request to "AUS" instead of "BGD". As a result, no matched campaign was found.

**Actual Response:**
```json
{
    "message": "Sorry, no suitable campaign was found for the bid request.",
    "campaign_details": []
}
```
