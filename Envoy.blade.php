@servers(['web' => 'www-data@66.228.62.211 -p8422'])

@task('deploy', ['on' => 'web'])
    cd /var/www/speaklikeabrazilian.com/public_html
    git pull origin master
    composer dump-autoload
    composer update --no-dev --prefer-dist --profile -vvv
    php artisan migrate
@endtask
