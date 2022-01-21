@include('../../vendor/autoload.php');

@setup
    \Dotenv\Dotenv::createImmutable(__DIR__, '.env')->load();

    $repository_url = env('REPOSITORY_URL');

    $server_host = env('SERVER_HOST');
    $server_port = env('SERVER_PORT');
    $server_username = env('SERVER_USERNAME');
    $server_app_path = env('SERVER_APP_PATH');
    $server_app_dir = env('SERVER_APP_DIR');

    $db_host = env('DB_HOST');
    $db_port = env('DB_PORT');
    $db_database = env('DB_DATABASE');
    $db_username = env('DB_USERNAME');
    $db_password = env('DB_PASSWORD');

    $app_url = env('APP_URL');
    $app_admin_url = env('APP_ADMIN_URL');
    $app_api_url = env('APP_API_URL');
@endsetup

@servers(['production' => [{{ $server_host }}], 'localhost' => '127.0.0.1'])

@import('tasks.blade.php');