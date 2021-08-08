<?php
/*
php artisan resource-file:create Timezones --fields=id,zone,gmt,country_code,published,sort
php artisan resource-file:create BusinessCategories --fields=id,title,parent_id,published,context_id,sort
php artisan resource-file:create JobCategories --fields=id,title,parent_id,published,context_id,sort
php artisan resource-file:create JobTitles --fields=id,title,context_id
php artisan resource-file:create Roles --fields=id,title,alias,section

php artisan resource-file:create JobCategoryTitles --fields=id,job_category_id,job_title_id
php artisan resource-file:create SysSettings --fields=id,key,value,type,description,published

php artisan create:resources Roles --force --without-timestamps --template-name=ajaxified
php artisan create:resources Roles --force --template-name=ajaxified


php artisan resource-file:create Skills --fields=id,title,published,context_id
php artisan create:resources Skills --force --without-timestamps --template-name=ajaxified

php artisan resource-file:create SysSettings --fields=id,key,value,published,type,description,created_at,updated_at
php artisan create:resources Skills --force --without-timestamps --template-name=ajaxified

php artisan resource-file:create Videos --fields=id,title,youtube_url,name: ;html-type:file,description,display_type,created_at,updated_at
php artisan create:resources Videos --force --without-timestamps --template-name=ajaxified


php artisan resource-file:create Categories --fields="id,title,name:published;html-type:select;options:true|false,created_at,updated_at" --force
php artisan create:resources Category --force --without-timestamps --template-name=ajaxified

php artisan resource-file:create Posts --fields="id,category_id,title,name:description;html-type:textarea,name:img_src;html-type:file,name:published;html-type:select;options:0|1,name:display_type;html-type:select;options:main|brief|unspecified,published_at,created_by,created_at,updated_at" --force
php artisan create:resources Post --force --without-timestamps --template-name=ajaxified


php artisan resource-file:create ContactusQueries --fields="id,name,email,phone,subject,name:details;html-type:textarea,created_at,updated_at" --force
php artisan create:resources ContactusQuery --force --template-name=ajaxified
 */