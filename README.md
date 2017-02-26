Put webpages inside apps, feel free to remove mine (since it's just for pre-alpha) or just use a new directory.Config probably will be different for mac and windows since they use different paths

To change postgres password
---------------------------
1) enter your phppgadmin page, http://127.0.0.1/phppgadmin/  
2) go under your database (probably named postgres)  
3) select sql  
4) enter the following and execute:  
alter role postgres with encrypted password 'cs2102';  
5) restart postgres server  

Restoring postgres dump  
-----------------------  
https://www.postgresql.org/docs/8.1/static/backup.html#BACKUP-DUMP-RESTORE  


Before executing the PHP files
---------------------------
1) Go to dbconnect.php to set up your credentials<br>
2) As the directory paths for Mac and Windows are different, kindly configure the path at line 109 in create_project.php

## Installation**

After the cloning the repo,

### Option 1
1. At the root directory, run `composer install` to install laravel dependencies.If you do not have composer, check https://getcomposer.org/doc/00-intro.md
2. Run `npm install` to install node dependencies
3. Start your postgres server (preferably with Bitnami)
4. Customize the `.env` file at the root to use your database. Run grp23.sql
5. Run `php artisan key:generate`
6. Run `npm run watch`. This is to ensure the public folder is up to date.
7. Start server with `php artisan serve`
8. Go to the url shown

### Option 2
1. Copy all the files into `/apache2/frameworks/laravel`
2. Start apache server
3. Start postgres server
4. Customize the `.env` file at the root to use your database. Run grp23.sql
3. Go to `http:localhost/laravel`

Note that option 2 is not recommended for development as Apache caches the framework and does not refresh after making changes to the files.
