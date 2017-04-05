## Installation**

After the cloning the repo,

### Option 1
1. At the root directory, run `composer install` to install laravel dependencies.If you do not have composer, check https://getcomposer.org/doc/00-intro.md
2. Get npm, https://www.npmjs.com/get-npm
3. Run `npm install` to install node dependencies
4. Start your postgres server (preferably with Bitnami)
5. Customize the `.env` file at the root to use your database. Run grp23.sql
6. Run `php artisan key:generate`
7. Run `npm run watch`. This is to ensure the public folder is up to date. (If you are using npm v3.10.10, rename package_v3.10.10.json to package.json and replace)
8. Start server with `php artisan serve`
9. Go to the url shown

### Option 2
1. Copy all the files into `/apache2/frameworks/laravel`
2. Start apache server
3. Start postgres server
4. Customize the `.env` file at the root to use your database. Run grp23.sql
3. Go to `http:localhost/laravel`

Note that option 2 is not recommended for development as Apache caches the framework and does not refresh after making changes to the files.


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
1) just run grp23.sql inside phppgadmin sql interface
2) https://www.postgresql.org/docs/8.1/static/backup.html#BACKUP-DUMP-RESTORE  
