Put webpages inside apps, feel free to remove mine (since it's just for pre-alpha) or just use a new directory. Config probably will be different for mac and windows since they use different paths

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
