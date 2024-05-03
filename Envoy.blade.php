@servers(['prod' => 'joeferguson@server.joeferguson.me'])

@task('deploy', ['on' => 'prod'])
cd /home/joeferguson/domains/isconklive.joeferguson.me/isconklive
git pull origin main
/usr/bin/php8.3 /usr/local/bin/composer install --no-dev
/usr/bin/php8.3 artisan migrate --force
@endtask
