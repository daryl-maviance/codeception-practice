# Codeception Practice: Booking API Tests

This repository contains automated tests for a Booking API using the Codeception testing framework. The tests are implemented in the `BookingCest` class and cover various functionalities of the API.

## Prerequisites

- PHP 7.4 or higher
- Composer
- Codeception installed globally or locally in the project

## Test Scenarios

The `BookingCest` class includes the following test scenarios:

1. **Get All Bookings**
   - Sends a `GET` request to `/booking`.
   - Verifies the response code, JSON format, and structure.

2. **Create Booking**
   - Sends a `POST` request to `/booking` with booking details.
   - Verifies the response code, JSON format, and structure.
   - Stores the `bookingId` for further use.

3. **Authenticate User**
   - Sends a `POST` request to `/auth` with user credentials.
   - Verifies the response code, JSON format, and structure.
   - Stores the authentication `token` for further use.

4. **Update Booking**
   - Sends a `PUT` request to `/booking/{id}` with updated booking details.
   - Requires authentication via a token.
   - Verifies the response code, JSON format, and structure.

## How to Run Tests

1. Clone the repository:
   ```bash
   git clone  https://github.com/daryl-maviance/codeception-practice.git
   cd codeception-practice
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Run the tests:
   ```bash
   vendor/bin/codecept run
   ```

## Notes

- The `BookingCest` class uses class properties to store the `token` and `bookingId` for reuse across tests.
- Ensure the API server is running and accessible before executing the tests.
- Update the API endpoints and credentials in the test methods if necessary.

## Directory Structure

```
/tests
  /Api
    BookingCest.php  # Contains the Booking API test cases
```
