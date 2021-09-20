# Julienmaster reviews

## About

This is a small blog I have created as an assignment for an interview.

## Installation

1. Clone or download the repository from Github.
2. Create a new database on your database server.
3. Create a seperate environment file for your personal settings. It is recommend to use .env.local. UNIX: `cp .env .env.local` Windows: `copy .env .env.local`.
4. Fill in the environment variable in .env.local. You can generate an APP_SECRET by executing `php bin/console make:command regenerate-app-secret`.
5. Install dependencies.
```bash
# Composer
$ composer install

# yarn or npm
$ yarn install
$ npm install
```
6. Run the database migrations by executing `php bin/console doctrine:migrations:migrate`.
7. Start a local server right away by executing `symfony server:start`. Or serve it on a local server such as Apache or NGINX.

## Importing data from a different server

If you want to import the data from one database to another you can follow these steps.
1. Get a dump of the database you want to export (usually a .sql file).
	1.1 If you're using MySQL, then you can use mysqldump. Execute `mysqldump -u {database_user} -p {database_name} > {output_file_path}`.
	1.2 If you're using MariaDB, then you can use mariadb-dump or mysql-dump (This is a symlink to the former). Execute `mariadb-dump -u {database_user} -p {database_name} > {output_file_path}`.
2. Make sure to also copy the uploads folder. This can be found under the public folder.
3. Import the dump by executing the relevant command.
	3.1 If the new database uses MySQL or MariaDB, then you can execute: `mysql -u {database_user} -p < {dump_file_path}`.
4. Paste/upload the uploads folder to the new server.
The new database now contains the same data.

## FAQ
Q: The Save button doesn't work.
A: This is a weird bug with the Tiny MCE editor. A workaround is to use the save button in the editor (First button on the toolbar) instead.

Q: The Tiny MCE editor shows the following message: "This domain is not registered with Tiny Cloud. Please review your approved domains."
A: To use Tiny MCE, you need to register the domain with them. This can by done by going to `https://www.tiny.cloud/my-account/domains/` and adding it to the list.
The editor is still usable on an unregisterd domain (including open-source plugins), but premium plugins will be disabled.