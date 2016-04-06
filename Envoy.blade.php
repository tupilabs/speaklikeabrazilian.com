@servers(['web' =>  'root@speaklikeabrazilian.com -p8422'])

@task('deploy', ['on' => 'web'])
    cd /var/www/speaklikeabrazilian.com/public_html
    git fetch --all
    git reset --hard origin/master
    git pull origin master
    composer dump-autoload
    composer update --no-dev --prefer-dist --profile -vvv --no-scripts
    php artisan migrate --force
@endtask
