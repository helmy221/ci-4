
CodeIgniter v4.6.3 Command Line Tool - Server Time: 2025-10-13 10:03:46 UTC+07:00

Running all new migrations...
[CodeIgniter\Database\Exceptions\DatabaseException]
Unable to connect to the database.
Main connection [MySQLi]: No such file or directory
at SYSTEMPATH/Database/BaseConnection.php:465

Backtrace:
  1    SYSTEMPATH/Database/BaseConnection.php:614
       CodeIgniter\Database\BaseConnection()->initialize()

  2    SYSTEMPATH/Database/BaseConnection.php:1525
       CodeIgniter\Database\BaseConnection()->query('SHOW TABLES FROM `pengadaan_terpadu_db`')

  3    SYSTEMPATH/Database/BaseConnection.php:1545
       CodeIgniter\Database\BaseConnection()->listTables()

  4    SYSTEMPATH/Database/MigrationRunner.php:768
       CodeIgniter\Database\BaseConnection()->tableExists('migrations')

  5    SYSTEMPATH/Database/MigrationRunner.php:162
       CodeIgniter\Database\MigrationRunner()->ensureTable()

  6    SYSTEMPATH/Commands/Database/Migrate.php:85
       CodeIgniter\Database\MigrationRunner()->latest(null)

  7    SYSTEMPATH/CLI/Commands.php:74
       CodeIgniter\Commands\Database\Migrate()->run([...])

  8    SYSTEMPATH/CLI/Console.php:47
       CodeIgniter\CLI\Commands()->run('migrate', [...])

  9    SYSTEMPATH/Boot.php:388
       CodeIgniter\CLI\Console()->run()

 10    SYSTEMPATH/Boot.php:133
       CodeIgniter\Boot::runCommand(Object(CodeIgniter\CLI\Console))

 11    ROOTPATH/spark:87
       CodeIgniter\Boot::bootSpark(Object(Config\Paths))

