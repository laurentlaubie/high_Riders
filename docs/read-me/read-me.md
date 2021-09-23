# High Rider read me.

## End of study project O'clock school section Ulysse.

### Hello, you can follow these recommendations to install on your computer the High Rider - Backend project.
  
- Create a .env.local file in the root of the high-riders folderand copy and paste this into it :
  
```php
`DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/high-riders_dev?serverVersion=5.7`
```

- Change 'db_user' to your database login, do the same for 'db_password'.
- Check your MySQL version with the command `mysql --version` and replace 5.7 by your version.

- run the command :
- `composer instal`

- run the command :
- `php bin/console doctrine:database:create`
- 
- Go to Adminer, connect to the database high-riders_dev, in the tab 'SQL command' copy, paste the file Adminer 4 in the folder Leav Dev Back of google drive of the project.
- run the command execute.

- Then open a terminal in your text editor and run the command `php -S 0.0.0.0:8080 -t public`. From your browser go to the URL http://localhost:8080/ and log in.
