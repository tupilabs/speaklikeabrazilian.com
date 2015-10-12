@servers(['web' =>  'root@45.56.78.89 -p22'])

@task('deploy', ['on' => 'web'])
    cd /var/www/speaklikeabrazilian.com/public_html
    git fetch --all
	git reset --hard origin/master
    git pull origin master
    composer dump-autoload
    composer update --no-dev --prefer-dist --profile -vvv --no-scripts
    php artisan migrate
@endtask
