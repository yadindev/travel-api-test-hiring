<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    /*
     * Your API path. By default, all routes starting with this path will be added to the docs.
     * If you need to change this behavior, you can add your custom routes resolver using `Scramble::routes()`.
     */
    'api_path' => 'api/v1/',

    /*
     * Your API domain. By default, app domain is used. This is also a part of the default API routes
     * matcher, so when implementing your own, make sure you use this config if needed.
     */
    'api_domain' => null,

    'info' => [
        /*
         * API version.
         */
        'version' => env('API_VERSION', '0.0.1'),

        /*
         * Description rendered on the home page of the API documentation (`/docs/api`).
         */
        'description' => "Welcome to our Trip and Tour Creation API! 🌍

Discover the power of seamless travel and tour management with our cutting-edge API. Whether you're a travel enthusiast, a tour operator, or a developer looking to integrate travel functionalities into your application, our API provides you with the tools you need to create, manage, and customize trips and tours with ease.

With our user-friendly endpoints, you can effortlessly design bespoke travel experiences, manage itineraries, handle bookings, and integrate various travel services. From creating personalized city tours to organizing adventurous expeditions, our API empowers you to bring travel dreams to life.

Our comprehensive documentation, intuitive endpoints, and robust support ensure that you can quickly get up and running, making the process of integrating travel functionalities a breeze. Experience the freedom to innovate and tailor travel experiences to match your vision.

Join us in shaping the future of travel technology and see how our API can elevate your travel and tour creation capabilities. Let's embark on this journey together! ✈️🗺️",
    ],

    /*
     * Customize Stoplight Elements UI
     */
    'ui' => [
        /*
         * Hide the `Try It` feature. Enabled by default.
         */
        'hide_try_it' => false,

        /*
         * URL to an image that displays as a small square logo next to the title, above the table of contents.
         */
        'logo' => '',

        /*
         * Use to fetch the credential policy for the Try It feature. Options are: omit, include (default), and same-origin
         */
        'try_it_credentials_policy' => 'include',
    ],

    /*
     * The list of servers of the API. By default, when `null`, server URL will be created from
     * `scramble.api_path` and `scramble.api_domain` config variables. When providing an array, you
     * will need to specify the local server URL manually (if needed).
     *
     * Example of non-default config (final URLs are generated using Laravel `url` helper):
     *
     * ```php
     * 'servers' => [
     *     'Live' => 'api',
     *     'Prod' => 'https://scramble.dedoc.co/api',
     * ],
     * ```
     */
    'servers' => null,

    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],
];
