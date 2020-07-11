<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>
Rest Api request 

*In The first you will be config env file 
*run composer install
*then run command php artisan migrate --seed , php artisan passport:install
*run php artisan serve

our  routes

/login (POST)
send value email , password 
we will be return you token and token type 
you will to use it the routes where required login set in header Authorization key with value  'token_type token'
/register (POST)
{
    name: 'Admin',
    email: 'admin@example.com',
    password: 'sadas'
}
required name, email ,password , password_confirmation fields
/logout (GET)

with Authorization
User Logout

/user (GET)
with Authorization
return logined user

/event (GET)
return eventlist with pagination limit 10 , and users who applied to event

/event(POST)
with Authorization
There required title and description 
you can send image name will be feature limit 1 
event_start must be date 
event_end Date 

/event/{id , slug} (GET)
return one event by slug or id

/event/{id,slug} (PUT , PATCH)
with Authorization.
Update Event .
Must Important field is creator_id , 
required title , description 
you can send image name will be feature limit 1 
event_start must be date 
event_end Date 

/event/{id , slug} ( DELETE )
Delete Event form db

/event/{id,slug}/apply (GET)
with Authorization.
user will be apply to event
