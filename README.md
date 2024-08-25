# the name of project
movie_library
# step to run the project 
1- add data base name in phpmyadmin
2- add the database name in .env
3- run the project in termial using this step:
   1 . php artisan config:cache
   2. php artisan config:clear
   //we put this step above (1+2) because in my project i put database name but you want to add new data so this is to clear .env and allow you to put your database
   3. php artisan migrate
   4. php artisan db:seed --class=CreateAdminSeeder
# what about this project
this project containe two role admin and user
admin can add movie and delete and update 
the user can see all movies and rating any film 
# doc of postman is 
https://documenter.getpostman.com/view/34555205/2sAXjF9avm

