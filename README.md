<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>
Rest Api request 

*In The first you will be config env file 
*run composer
*then run command php artisan migrate --seed
*run php artisan 
our  routes

/login (POST)
send value email , password 
we will be return you token and token type 
you will to use it the routes where required login set in header Authorization key with value  'token_type token'
/register (POST)
