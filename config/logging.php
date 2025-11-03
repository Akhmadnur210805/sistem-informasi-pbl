<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | Menentukan saluran (channel) log default yang digunakan Laravel
    | untuk menulis catatan log. Nilainya diambil dari file .env
    | menggunakan variabel LOG_CHANNEL, default-nya adalah 'stack'.
    |
    */
    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | Bagian ini digunakan untuk mencatat log fitur PHP atau library
    | yang sudah usang (deprecated). Hal ini membantu pengembang
    | untuk mempersiapkan upgrade ke versi berikutnya.
    |
    */
    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => env('LOG_DEPRECATIONS_TRACE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Daftar saluran (channel) log yang tersedia di aplikasi Laravel.
    | Masing-masing channel memiliki cara dan tempat penyimpanan log
    | yang berbeda (file, harian, Slack, sistem, dll).
    |
    | Driver yang tersedia: "single", "daily", "slack", "syslog",
    | "errorlog", "monolog", "custom", "stack"
    |
    */
    'channels' => [

        // Channel utama yang menggabungkan beberapa channel lain
        'stack' => [
            'driver' => 'stack',
            'channels' => explode(',', (string) env('LOG_STACK', 'single')),
            'ignore_exceptions' => false,
        ],

        // Channel sederhana, menyimpan semua log ke satu file
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'), // Level log default
            'replace_placeholders' => true,
        ],

        // Channel yang membuat file log baru setiap hari
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => env('LOG_DAILY_DAYS', 14), // Simpan log selama 14 hari
            'replace_placeholders' => true,
        ],

        // Channel untuk mengirim log ke Slack (notifikasi tim)
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => env('LOG_SLACK_USERNAME', 'Laravel Log'),
            'emoji' => env('LOG_SLACK_EMOJI', ':boom:'), // Emoji notifikasi
            'level' => env('LOG_LEVEL', 'critical'),
            'replace_placeholders' => true,
        ],

        // Channel untuk mengirim log ke layanan Papertrail (cloud log management)
        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        // Channel untuk menampilkan log ke output terminal (stderr)
        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'handler_with' => [
                'stream' => 'php://stderr',
            ],
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'processors' => [PsrLogMessageProcessor::class],
        ],

        // Channel yang mengirim log ke sistem operasi (syslog)
        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => env('LOG_SYSLOG_FACILITY', LOG_USER),
            'replace_placeholders' => true,
        ],

        // Channel menggunakan fungsi bawaan PHP error_log()
        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        // Channel yang tidak menyimpan log sama sekali (semua diabaikan)
        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        // Channel darurat (emergency) digunakan jika semua channel gagal
        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

];
