<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default QR Code Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default QR code "driver" that will be used to
    | generate QR codes. You may set this to the name of any of the drivers
    | defined below.
    |
    */

    'default' => env('QR_CODE_DRIVER', 'gd'),

    /*
    |--------------------------------------------------------------------------
    | QR Code Drivers
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the QR code "drivers" for your application
    | as well as their settings. You may even define multiple drivers of
    | the same driver's type, and multiple drivers with different settings.
    |
    */

    'drivers' => [

        'gd' => [
            'driver' => 'gd',
        ],

        'tcpdf' => [
            'driver' => 'tcpdf',
            'module_size' => 2,
            'format' => 'QRCODE,H',
            'color' => '000000',
            'background' => 'FFFFFF',
        ],

        'dompdf' => [
            'driver' => 'dompdf',
            'options' => [],
        ],

    ],

];
