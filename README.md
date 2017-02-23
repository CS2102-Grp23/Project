
To change postgres password
---------------------------
1) enter your phppgadmin page, http://127.0.0.1/phppgadmin/
2) go under your database (probably named postgres)
3) select sql
4) enter the following and execute:
alter role postgres with encrypted password 'cs2102';
5) restart postgres server
