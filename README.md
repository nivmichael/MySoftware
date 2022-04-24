## _PHP training_
In this training we'll create a PHP program that will run on a local environment, using OOP principals.
We'll create a simple blog like site. This will allow us to go over a lot of the  pricipals and code that will help you become a better PHP programmer.
Please follow the steps, and read the note on each step for insctructions.
After each step there will be a code review, and a quick explanation on the next step.

## The steps:

- Setup a local environment using PHP, APACHE and MySQL (XAMMP or windows / global installation Linux)
- Using MySQL CLI, create a "blog" database, with a "users" table. Insert one user.
- Create a Login page (index.php)
- Create an autoload class in the root of application
- Validate user againt Database
- Once logged in - redirect to admin.view.php page
- Create a form to upload blog posts
- Validating the data on the server
- Saving the data into a DB
- Saving the files on the server
- See the data in index.php

## Notes on the steps
### Setup a local environment using PHP, APACHE and MySQL (XAMMP or windows / global installation Linux)
Windows:
- Dowload XAMPP
- Set up a local site named blog.co in C:\Windows\System32\drivers\etc\host file
- Set up a virtual host (blog.co) in XAMPP's httpd-vhosts.conf file pointing to this project

Linux:
https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04

### Using Mysql CLI, create a "blog" database, with a "users" table. Insert one user.
The users table should have these fields:
1. id | Auto-increment 
2. username | varchar 100
3. password | varchar 100
4. created_at datetime

Insert one user into the table.
Save all the commands in the changes.sql file

### Create a popup login page (index.php)
Once the local site is set up, create a login button in index.php.
This button will open a dialog. In the dialog wil be a form to submit the username (email) and password.
The data should be sent to login.rpc.php.

### Create an autoload class in the root of application
Autoload all the classes in the "inc" folder

### Validate user againt Database
In the login.rpc.php, check if the user's credentials are OK, using the login.class.php and db.class.php
Save login in cookie for persistant login.
db.class.php should handle the mysqli connection to the server

### Once logged in - redirect to dmin.view.php page
### Create a form to upload blog posts
In the admin view, create a form that allows to upload a blog post, consisting from:
1. Title
2. Body
3. Image file

### Validating the data on the server
Create a admin.rpc.php and an admin.class.php files to validate the data.

### Saving the data into a DB
Use the admin.class.php class to save the post into the DB.
Create a posts table to hold the data.
### Saving the files on the server
Using the admin.class.php to dave the $_FILES data to the posts_images folder, with the post id as subfolder
### See the data in index.php
When going into index.php, show all the posts in the page. 
If we're logged in, displat a logout button instead of the login button.


## Important
Please feel free ask question to better understand the required design of the app.
Use best practices.
Try and solve as much as you can by your own.
