#Clears caches just in case
./vendor/bin/sail artisan optimize:clear
#Create new APP_KEY - used for hashing
./vendor/bin/sail artisan key:generate
#Migrations
./vendor/bin/sail artisan migrate:refresh
#Seeders
./vendor/bin/sail artisan db:seed --class=Database\\Seeders\\V1\\DatabaseSeeder
