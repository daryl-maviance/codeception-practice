<?php

declare(strict_types=1);

namespace Tests\Api;

use Tests\Support\ApiTester;

final class BookingCest
{
    private string $token; // Class property to store the token
    private int $bookingId; // Class property to store the booking ID

    public function _before(ApiTester $I): void
    {
        // Code here will be executed before each test.
    }

    public function tryToTest(ApiTester $I): void
    {
        // Write your tests here. All `public` methods will be executed as tests.
    }

    public function getAllBookings(ApiTester $I)
    {
        $I->sendGet('/booking');

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'bookingid' => 'integer'
        ], '$[*]');
         
        $I->comment('Response: ' . $I->grabResponse());
    }

    public function createBooking(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json'); // Ensure correct response type

        $payload = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'totalprice' => 150,
            'depositpaid' => true,
            'bookingdates' => [
                'checkin' => '2024-01-01',
                'checkout' => '2024-01-05'
            ],
            'additionalneeds' => 'Breakfast'
        ];

        $I->sendPost('/booking', $payload);

        codecept_debug($I->grabResponse());

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'bookingid' => 'integer',
            'booking' => [
                'firstname' => 'string',
                'lastname' => 'string',
                'totalprice' => 'integer',
                'depositpaid' => 'boolean',
                'bookingdates' => [
                    'checkin' => 'string',
                    'checkout' => 'string'
                ],
                'additionalneeds' => 'string'
            ]
        ]);

        // Store the booking ID in the class property
        $this->bookingId = $I->grabDataFromResponseByJsonPath('$.bookingid')[0];
    }

    public function authenticateUser(ApiTester $I)
    {
        $payload = [
            "username" => "admin",
            "password" => "password123"
        ];

        $I->sendPost('/auth', $payload);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'token' => 'string'
        ]);

        // Store the token in the class property
        $this->token = $I->grabDataFromResponseByJsonPath('$.token')[0];
    }

    public function updateBooking(ApiTester $I)
    { 
        $bookId = $this->bookingId; // Retrieve the booking ID from the class property

        // Ensure the token is set
        if (!isset($this->token)) {
            $this->authenticateUser($I); // Authenticate and retrieve the token if not already set
        }

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json');
        $I->haveHttpHeader('Cookie', 'token=' . $this->token);

        $payload = [
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'totalprice' => 200,
            'depositpaid' => false,
            'bookingdates' => [
                'checkin' => '2024-02-01',
                'checkout' => '2024-02-10'
            ],
            'additionalneeds' => 'Lunch'
        ];

        $I->sendPut('/booking/' . $bookId, $payload);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        codecept_debug($I->grabResponse());
    }
}
