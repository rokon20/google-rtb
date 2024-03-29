# Real-Time Bidding (RTB) Banner Campaign Response

This project implements a PHP script to handle bid requests and generate appropriate banner campaign responses for Real-Time Bidding (RTB) scenarios.

## Installation

1. Clone the repository:

```
git clone https://github.com/rokon20/google-rtb
```

2. Navigate to the project directory:

```
cd google-rtb
```

3. Run the container using Docker Compose:

```
docker-compose up --build -d
```

4. Access the endpoint:

The API endpoint will be available at http://localhost:8080.

## Testing

1. Use a tool like Postman to send a POST request to the endpoint: http://localhost:8080.

2. Set the request body to the bid JSON data from the file `json_data/bid_request.json`.

3. Make sure the body content type is set to JSON.

4. Send the request and observe the response.

## Sample Bid JSON Data

- Please refer to the file `json_data/bid_request.json` for a sample bid JSON data.
