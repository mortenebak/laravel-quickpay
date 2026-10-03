<?php

declare(strict_types=1);

// config for Netbums/Quickpay
return [
    'api_key'     => env('QUICKPAY_API_KEY'),
    'login'       => env('QUICKPAY_LOGIN'),
    'password'    => env('QUICKPAY_PASSWORD'),
    'merchant_id' => env('QUICKPAY_MERCHANT_ID'),

    // Used to verify the checksum of callbacks. Found under Settings > Integration in the Quickpay manager.
    'private_key' => env('QUICKPAY_PRIVATE_KEY'),
];
