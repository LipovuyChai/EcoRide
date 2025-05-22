<?php

return [

    /*
     * The name of the cookie in which we store if the user
     * has agreed to accept the conditions.
     */
    'cookie_name' => 'cookie_for_consent',

    /*
     * Set the cookie duration in days.  Default is 365 * 20.
     */
    'cookie_lifetime' => 365 * 20,

    /*
     * Cookie categories for GDPR compliance
     */
    'cookie_categories' => [
        'essential' => [
            'name' => 'Essential',
            'description' => 'These cookies are essential for the website to function properly.',
            'required' => true,
        ],
        'analytics' => [
            'name' => 'Analytics',
            'description' => 'These cookies help us understand how visitors interact with the website.',
            'required' => false,
        ],
        'marketing' => [
            'name' => 'Marketing',
            'description' => 'These cookies are used to deliver personalized advertisements.',
            'required' => false,
        ],
    ],
];
