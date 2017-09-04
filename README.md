# Complete Guideline For NASA API
**Setup Development Environment**
          
   1. Install PhalconPHP Framework. (I choose PhalconPHP Framework because it is fastest framework built in C and deliver as an extension. PhalconPHP provides the lowest overhead for MVC-based applications)
   2. Execute nasa.sql file in your MySQL database.
   3. Setup Nginx or alternative web server. I have used nginx as web server. following is the complete nginx configuration.
>    server {
>         listen   80;
>      

>         server_name www.nasa.in;
>         root /usr/share/nginx/html/projects/nasa;
>         index index.php index.html index.htm;

>         autoindex on;
>       
>         location  /api {
>             alias /usr/share/nginx/html/projects/nasa/api/public/;
>             index index.php; 
>             rewrite ^/api/(.*)$  /api/index.php?_url=/ last;

>             location ~ \.php$ {
>                 fastcgi_split_path_info ^(.+?\.php)(/.*)?$;
>                 fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
>                 fastcgi_index index.php;
>                 include fastcgi_params;
>                 fastcgi_param SCRIPT_FILENAME $request_filename;
>             }      
>         }



>         # pass the PHP scripts to FastCGI server listening on the php-fpm socket
>         location ~ \.php$ {
>                 try_files $uri =404;
>                 fastcgi_pass unix:/var/run/php/php7.0-fpm.sock;
>                 fastcgi_index index.php;
>                 fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
>                 include fastcgi_params;
>                 
>         }

>         location ~ /\.ht {
>                 deny all;
>         }


> }


**Complete NASA API List.**

   1. http://www.nasa.in/api/neo/save-neo (Get NEO from NASA and stores it in our database)
        > Output :  {"content":{"message":"Data saved successfully"}}  
 
   2. http://www.nasa.in/api/neo/hazardous (Get all the potentially hazardous asteroids)
        > Output :  {"content":{"result_set":[{"id":"155","name":"(2015 CX12)","reference_id":"3710160","speed":"85713.2418355560","is_hazardous":"1","neo_date":"2017-09-01"},{"id":"177","name":"418416 (2008 LV16)","reference_id":"2418416","speed":"46197.3518459410","is_hazardous":"1","neo_date":"2017-08-31"}],"count":2}} 
 

   3. http://www.nasa.in/api/neo/fastest/{true|false} (Get fastest haz/non-haz ateroid based on the kilometers_per_hour. By default it will return fastest non-haz ateroid )
        > Output :  {"content":{"result_set":[{"id":"155","name":"(2015 CX12)","reference_id":"3710160","speed":"85713.2418355560","is_hazardous":"1","neo_date":"2017-09-01"}],"count":1}}


   4. http://www.nasa.in/api/neo/best-year/{true|false} (Get year with most haz/non-haz ateroid based on parameter. By default it will return year with most non-haz ateroid )
        > Output : {"content":{"result_set"[{"neo_best_year":"2017","total_number_of_ateroids":"2"}],"count":1}}
 
   5. http://www.nasa.in/api/neo/best-month/{true|false} (Get month with most haz/non-haz ateroid based on parameter. By default it will return month with most non-haz ateroid )
        > Output : {"content":{"result_set":[{"neo_best_month":"9","total_number_of_ateroids":"1"}],"count":1}}
          


           

                 
