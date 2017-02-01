## Laravel DBTruncate Command

Automatically truncates all mysql tables for you. Works also with tables that use relationships, by using the  `FOREIGN_KEY_CHECKS` system variable.

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `kreshnik/dbtruncate`

    "require-dev": {
<<<<<<< HEAD
		"kreshnik/dbtruncate": "dev-master"
=======
		"kreshnik/dbtruncate": "5.3"
>>>>>>> 64df2b6c6c145395aace73e392d4e2eab23a4a26
	}

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the final step is to add the service provider. Open `config/app.php`, and add a new item to the providers array.

    Kreshnik\Dbtruncate\DbtruncateServiceProvider::class

That's it! You're all set to go. Run the `artisan` command from the Terminal to see the new `db:truncate` command.

    php artisan

## Commands

`db:truncate` will prompt you to confirm the truncation process

### Options
`db:truncate --tables=table1,table2` In case you want to truncate specific tables. You can specify a list of tables divided with a comma.

`db:truncate --exclude=table1,table2` A list of tables that will be excluded from the truncation process. The tables have to be divded with a comma.
