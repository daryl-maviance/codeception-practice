<?php
return[
    'create_booking' =>[
        'payload' => [
            "firstname" => "Jim",
            "lastname" => "Brown",
            "totalprice" => 111,
            "depositpaid" => true,
            "bookingdates" => [
                "checkin" => "2018-01-01",
                "checkout" => "2019-01-01"
            ],
            "additionalneeds" => "Breakfast"
        ],
        'response' => [
            'firstname' => 'Jim',
            'lastname' => 'Brown',
            'totalprice' => 111,
            'depositpaid' => true,
            'bookingdates' => [
                'checkin' => '2018-01-01',
                'checkout' => '2019-01-01'
            ],
            'additionalneeds' => 'Breakfast'
        ]
    ],

    'update_booking' => [
        'payload' => [
            "firstname" => "Daryl",
            "lastname" => "White",
            "totalprice" => 222,
            "depositpaid" => false,
            "bookingdates" => [
                "checkin" => "2018-01-01",
                "checkout" => "2019-01-01"
            ],
            "additionalneeds" => "Breakfast"
        ],
        'response' => [
            'firstname' => 'Daryl',
            'lastname' => 'White',
            'totalprice' => 222,
            'depositpaid' => false,
            'bookingdates' => [
                'checkin' => '2018-01-01',
                'checkout' => '2019-01-01'
            ],
            'additionalneeds' => 'Breakfast'
        ]
    ],

    'partiallly_update_booking' => [
        'payload' => [
            'totalprice' => 333000,
            'depositpaid' => true,
            'additionalneeds' => 'Bread'
        ],
        'response' => [
            'totalprice' => 333000,
            'depositpaid' => true,
            'additionalneeds' => 'Bread'
        ]
    ]

]

?>