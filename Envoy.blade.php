@servers(['web' => ['anirudh@skyronic.com']])

@task('deploy', ['on' => 'web'])
cd ~/sites/timezen
git pull origin master
composer install --optimize-autoloader
yarn install
yarn prod
php artisan migrate --force


@endtask