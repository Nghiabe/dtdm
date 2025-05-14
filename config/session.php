<?php

use Illuminate\Support\Str;

return [

    /*
    |----------------------------------------------------------------------
    | Default Session Driver
    |----------------------------------------------------------------------
    | 
    | Here you may specify the session driver to be used by your application.
    | Supported: "file", "cookie", "database", "apc", "memcached", "redis",
    |            "dynamodb", "array".
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),  // Chọn driver cho session, có thể là 'cookie', 'database', 'file', v.v.

    /*
    |----------------------------------------------------------------------
    | Session Lifetime
    |----------------------------------------------------------------------
    | 
    | Define the number of minutes you want the session to be allowed to 
    | remain idle before it expires. Set to 0 for sessions that never expire.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),  // Thời gian session tồn tại (phút)
    'expire_on_close' => false,  // Chọn 'false' để session không bị xóa khi đóng trình duyệt

    /*
    |----------------------------------------------------------------------
    | Session Encryption
    |----------------------------------------------------------------------
    |
    | This option allows you to easily specify that all of your session data
    | should be encrypted before it is stored.
    |
    */

    'encrypt' => false,  // Để lưu trữ session không bị mã hóa, bạn có thể chuyển thành true nếu cần.

    /*
    |----------------------------------------------------------------------
    | Session File Location
    |----------------------------------------------------------------------
    |
    | When using the "file" session driver, you may specify a location to
    | store the session files.
    |
    */

    'files' => storage_path('framework/sessions'),  // Đường dẫn đến thư mục lưu trữ session nếu dùng 'file'

    /*
    |----------------------------------------------------------------------
    | Session Database Connection
    |----------------------------------------------------------------------
    |
    | If using the "database" or "redis" session drivers, specify the
    | connection that should be used to manage sessions.
    |
    */

    'connection' => env('SESSION_CONNECTION'),  // Cấu hình kết nối database nếu bạn sử dụng session trong database

    /*
    |----------------------------------------------------------------------
    | Session Table
    |----------------------------------------------------------------------
    |
    | If using the "database" session driver, specify the table that should
    | be used to manage the sessions.
    |
    */

    'table' => 'sessions',  // Tên bảng trong database nếu bạn sử dụng driver 'database'

    /*
    |----------------------------------------------------------------------
    | Session Cache Store
    |----------------------------------------------------------------------
    |
    | When using a cache driver for sessions, specify the cache store
    | that should be used for storing session data.
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |----------------------------------------------------------------------
    | Session Lottery
    |----------------------------------------------------------------------
    |
    | This option defines how often the session storage should be cleaned
    | up by the session sweeper.
    |
    */

    'lottery' => [2, 100],  // Xác suất tự động dọn dẹp session

    /*
    |----------------------------------------------------------------------
    | Session Cookie Name
    |----------------------------------------------------------------------
    |
    | This option defines the name of the session cookie.
    |
    */

    'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel'), '_').'_session'),

    /*
    |----------------------------------------------------------------------
    | Session Cookie Path
    |----------------------------------------------------------------------
    |
    | The path the session cookie should be available to.
    |
    */

    'path' => '/',

    /*
    |----------------------------------------------------------------------
    | Session Cookie Domain
    |----------------------------------------------------------------------
    |
    | The domain of the cookie.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |----------------------------------------------------------------------
    | Secure Session Cookies
    |----------------------------------------------------------------------
    |
    | Whether to only send session cookies over HTTPS.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE', false),  // Chọn true nếu chạy trên HTTPS

    /*
    |----------------------------------------------------------------------
    | HTTP-Only Cookies
    |----------------------------------------------------------------------
    |
    | Whether the session cookie should be accessible via JavaScript.
    |
    */

    'http_only' => true,

    /*
    |----------------------------------------------------------------------
    | Same-Site Cookies
    |----------------------------------------------------------------------
    |
    | Controls how cookies behave during cross-site requests.
    |
    */

    'same_site' => 'lax',  // Bạn có thể chọn 'strict', 'lax' hoặc 'none'

];
