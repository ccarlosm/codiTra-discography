#Clears caches just in case
sail artisan optimize:clear
#Create new APP_KEY - used for hashing
sail artisan key:generate
#Migrations
sail artisan migrate:refresh
#Seeders
sail artisan db:seed --class=Database\\Seeders\\V1\\DatabaseSeeder
