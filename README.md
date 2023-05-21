## _PHP training_
In this training we'll create a PHP program that will run on a local environment, using OOP principals.
We'll create a simple blog like site. This will allow us to go over a lot of the  pricipals and code that will help you become a better PHP programmer.
Please follow the steps, and read the note on each step for insctructions.
After each step there will be a code review, and a quick explanation on the next step.

## The steps:
- Setup a local environment using PHP, Caddy server and MySQL
- After cloning the project, create a new branch with your name, to work on
- Create an page that displays data from API
- Using MySQL CLI, create a "blog" database, with a "users" table. Insert one user.
- Create a Login page (index.php)
- Create an autoload class in the root of application
- Validate user againt Database
- Once logged in - show user name and time from last login
- Create a form to upload blog posts
- Validating the data on the server
- Saving the data into a DB
- Saving the files on the server
- See the data in index.php

## Notes on the steps
### Setup a local environment using PHP, Caddy and MySQL (global installation Linux)
Linux:
- Install PHP 8.1
- Install Caddy server
- Install MySQL + MySQL workbench
- clone project into /var/www/

Windows (depracated):
- Dowload XAMPP
- Set up a local site named blog.co in C:\Windows\System32\drivers\etc\host file
- Set up a virtual host (blog.co) in XAMPP's httpd-vhosts.conf file pointing to this project



### Create an page that displays data from API - Optional!!!
1. Download nanoajax as a local js file to use for AJAX calls 
2. Use this link (https://jsonplaceholder.typicode.com/posts) to get json result, and show them in the 'results' div
3. Filter the posts, keep only the the ones with titles that begin with the letter 'e'
4. Each post should have a container with 'title' and 'body'
5. Make the body hidden unless the title was clicked (optional)
6. Use css (flex or grid) to arrange the posts in two columns, side by side

### Using Mysql CLI, create a "blog" database, with a "users" table. Insert one user.
The users table should have these fields:
1. id | Auto-increment 
2. username | varchar 100
3. password | varchar 100
4. created_at datetime
5. last_login ???

!Save all the commands in the changes.sql file
Insert one user into the table.
Add an 'address'column to the table.


### Create a popup login page (index.php)
Once the local site is set up, create a login button in index.php.
This button will open a dialog. In the dialog wil be a form to submit the username (email) and password.
The data should be sent to user.rpc.php.

### Create an autoload class in the root of application
Autoload all the classes in the "inc" folder

### Validate user againt Database
In the user.rpc.php, check if the user's credentials are OK, using the user.class.php and db.class.php
Save login in cookie for persistant login.
db.class.php should handle the mysqli connection to the server
rpc files return a json object to the client.

### Once logged in - show user name and time from last login
### Show a form to upload blog posts
In the admin view, create a form that allows to upload a blog post, consisting from:
1. Title
2. Body
3. Image file

### Validating the data on the server
Create a post.rpc.php and an post.class.php files to validate the data.

### Saving the data into a DB
Use the post.class.php class to save the post into the DB.
Create a posts table to hold the data.
### Saving the files on the server
Using the post.class.php to dave the $_FILES data to the posts_images folder, with the post id as subfolder
### See the data in index.php
1. When going into index.php, show all the posts in the page. 
2. Add filter by name in js
3. If we're logged in, display a logout button instead of the login button.


## Important
Please feel free ask questions to better understand the required design of the app.
Use best practices and the MMD code design document.
Try and solve as much as you can by your own.
