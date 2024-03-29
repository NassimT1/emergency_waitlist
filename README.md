# emergency_waitlist
## How to run
### Setup the database
1- Use XAMPP to run Apache and MySQL. Access http://localhost/phpmyadmin/ to create the database ```emergency_waitlist``` and the table ```patient``` using the SQL code from ```/database/create_table.sql```. 

2- In the [db_connection.php](/database/db_connection.php) file, modify the hostname, username, and password and database name if necessary.

3- Run the PHP server from the [index.php](/public/index.php) file.

For more information, please check the [design system](/docs/design_system.md) file to see how to use the application.