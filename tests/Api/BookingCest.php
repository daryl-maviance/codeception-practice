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
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Accept', 'application/json'); 

    }


    public function authenticateUser(ApiTester $I)
    {
        $I->wantTo('Authenticate a user');
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


    public function getBooking(ApiTester $I)
    {
        $I->wantTo('Get a booking');
        $I->sendGet('/booking/' . $this->bookingId);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'firstname' => 'string',
            'lastname' => 'string',
            'totalprice' => 'integer',
            'depositpaid' => 'boolean',
            'bookingdates' => [
                'checkin' => 'string',
                'checkout' => 'string'
            ],
            'additionalneeds' => 'string'
        ]);
    }


    public function checkUserAuthentication(ApiTester $I)
    {
        $I->wantTo('Check user authentication');
        $I->sendDelete('/booking/' . $this->bookingId);
        $I->seeResponseCodeIs(403);
    }


    public function getAllBookings(ApiTester $I)
    {
        $I->wantTo('Get all bookings');
        $I->sendGet('/booking');
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'bookingid' => 'integer'
        ], '$[*]');
         
    }


    public function createBooking(ApiTester $I)
    {
        $I->wantTo('Create a booking');
       
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


    public function updateBooking(ApiTester $I)
    { 
        $I->wantTo('Update a booking');
        // Ensure the token is set
        if (!isset($this->token)) {
            $this->authenticateUser($I); // Authenticate and retrieve the token if not already set
        }

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

        $I->sendPut('/booking/' .$this->bookingId, $payload);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'firstname' => 'string',
            'lastname' => 'string',
            'totalprice' => 'integer',
            'depositpaid' => 'boolean',
            'bookingdates' => [
                'checkin' => 'string',
                'checkout' => 'string'
            ],
            'additionalneeds' => 'string'
        ]);
    }


    public function PartiallyUpdateBooking(ApiTester $I)
    {
        $I->wantTo('Partially update a booking');
        // Ensure the token is set
        if (!isset($this->token)) {
            $this->authenticateUser($I); // Authenticate and retrieve the token if not already set
        }

        $I->haveHttpHeader('Cookie', 'token=' . $this->token);

        $payload = [
            'firstname' => 'Jane',
            'lastname' => 'Smith'
        ];

        $I->sendPatch('/booking/' . $this->bookingId, $payload);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'firstname' => 'string',
            'lastname' => 'string',
            'totalprice' => 'integer',
            'depositpaid' => 'boolean',
            'bookingdates' => [
                'checkin' => 'string',
                'checkout' => 'string'
            ],
            'additionalneeds' => 'string'
        ]);

        $I->seeResponseContainsJson([
            'firstname' => 'Jane',
            'lastname' => 'Smith'
        ]);
    }

    public function deleteBooking(ApiTester $I)
    {
        $I->wantTo('Delete a booking');
        // Ensure the token is set
        if (!isset($this->token)) {
            $this->authenticateUser($I); // Authenticate and retrieve the token if not already set
        }

        $I->haveHttpHeader('Cookie', 'token=' . $this->token);
        $I->sendDelete('/booking/' . $this->bookingId);
        $I->seeResponseCodeIs(201);
      
    }
}
