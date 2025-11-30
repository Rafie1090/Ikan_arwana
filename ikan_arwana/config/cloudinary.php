<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | An HTTP or HTTPS URL to notify your application (a callback) when the process of uploads,
    | deletes, and any other image manipulations are completed.
    |
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),


    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. Cloudinary is a cloud hosted
    | media management service for all your file uploads, storage, delivery and
    | transformation needs.
    |
    */
    'cloud_url' => env('CLOUDINARY_URL'),

    /**
    * Upload Preset From Cloudinary Dashboard
    *
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /**
    * Upload Route
    *
    */
    'upload_route' => env('CLOUDINARY_UPLOAD_ROUTE'),

    /**
    * Controller Route
    *
    */
    'controller_route' => env('CLOUDINARY_CONTROLLER_ROUTE'),

];
