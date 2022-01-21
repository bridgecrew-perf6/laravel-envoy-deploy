@story('deployment_first')
    clone
    composer
    env-file
    migrate
    node-modules
    build-assets
    set-permissions
    set-cache
    storage-link
    finish
@endstory

@story('deployment')
    down
    pull
    composer
    migrate
    node-modules
    build-assets
    set-cache
    flush-cache
    up
    finish
@endstory

@task('clone', ['on' => 'production', 'confirm' => true])
    cd {{ $server_app_path }}
    if [ -d {{ $server_app_dir }} ]; then
        echo -e "\e[34mDirectory project already exists (continue...)"
    else
        mkdir {{ $server_app_dir }}
    fi
    cd {{ $server_app_dir }}
    @if ($branch)
        git clone {{ $repository_url }} --branch={{ $branch }} .
        echo -e "\e[93mFinish task clone repository"
    @endif
@endtask

@task('pull', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    @if ($branch)
        git pull origin {{ $branch }}
        echo -e "\e[93mFinish task pull repository"
    @endif
@endtask

@task('composer', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    php -d memory_limit=-1 /usr/local/bin/composer install --prefer-dist --no-interaction --optimize-autoloader
    echo -e "\e[93mFinish task composer"
@endtask

@task('env-file', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    echo -e "\e[35mSetting variables ENV (continue...)"
    php artisan key:generate --force
    echo -e "\e[93mFinish task env-file"
@endtask

@task('migrate', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    php artisan migrate --force
    echo -e "\e[93mFinish task migrate"
@endtask

{{-- Edit line 71 --}}
@task('node-modules', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    /PATH/.nvm/versions/node/VERSION/bin/npm install
    echo "Finish task install-node-modules"
@endtask

{{-- Edit line 78 --}}
@task('build-assets', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    /PATH/.nvm/versions/node/VERSION/bin/npm run production
    echo "Finish task build-assets"
@endtask

@task('set-permissions', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    chmod -R ug+rwx storage bootstrap/cache
    echo -e "\e[93mFinish task set-permissions"
@endtask

@task('set-cache', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
    php /usr/local/bin/composer dump-autoload
    echo -e "\e[93mFinish task set-cache"
@endtask

@task('clear-cache', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan event:clear
    echo -e "\e[93mFinish task clear-cache"
@endtask

@task('flush-cache', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    php artisan cache:clear
    echo -e "\e[93mFinish task flush-redis-cache"
@endtask

@task('storage-link', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    php artisan storage:link
    echo -e "\e[93mFinish task storage-link"
@endtask

@task('up', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    php artisan up
    echo -e "\e[93mFinish task up"
@endtask

@task('down', ['on' => 'production'])
    cd {{ $server_app_path }}{{ $server_app_dir }}
    php artisan down --message="Site under maintenance"
    echo -e "\e[93mFinish task down"
@endtask

@task('finish', ['on' => 'production'])
    echo -e "\e[46m####### Finished deploy #######"
@endtask