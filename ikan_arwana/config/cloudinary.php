<?php

/*
|--------------------------------------------------------------------------
| Cloudinary Configuration
|--------------------------------------------------------------------------
|
| We manually parse the CLOUDINARY_URL to ensure the keys are available
| even if the package fails to parse the URL automatically.
|
*/

$url = env('CLOUDINARY_URL');
$cloud_name = null;
$api_key = null;
$api_secret = null;

if ($url && strpos($url, 'cloudinary://') === 0) {
    // Format: cloudinary://API_KEY:API_SECRET@CLOUD_NAME
    $parsed = parse_url($url);
    if ($parsed) {
        $cloud_name = $parsed['host'] ?? null;
        $api_key = $parsed['user'] ?? null;
        $api_secret = $parsed['pass'] ?? null;
    }
}

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),
    
    // We set this to null to prevent the package from trying to parse it again
    // and potentially failing or overwriting our manual 'cloud' config.
    'cloud_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Cloud Credentials
    |--------------------------------------------------------------------------
    |
    | Explicitly define the credentials in case the package looks for this array.
    |
    */
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME', $cloud_name),
        'api_key'    => env('CLOUDINARY_API_KEY', $api_key),
        'api_secret' => env('CLOUDINARY_API_SECRET', $api_secret),
    ],

    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
    'upload_route' => env('CLOUDINARY_UPLOAD_ROUTE'),
    'controller_route' => env('CLOUDINARY_CONTROLLER_ROUTE'),
];
