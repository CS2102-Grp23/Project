
To change postgres password
---------------------------
1) enter your phppgadmin page, http://127.0.0.1/phppgadmin/ <br\>
2) go under your database (probably named postgres) <br\>
3) select sql <br\>
4) enter the following and execute: <br\>
alter role postgres with encrypted password 'cs2102'; <br\>
5) restart postgres server <br\>
