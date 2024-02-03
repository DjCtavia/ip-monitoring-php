# Setup project

- Install **XAMPP** ([XAMPP installer Windows 64 With PHP 7.4](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/xampp-windows-x64-7.4.33-0-VC15-installer.exe/download))
- Install **composer** (https://getcomposer.org/download/) 

### Installing pthreads for PHP
- Download **parallel** for PHP ([parallel extension PHP for Windows x64](https://windows.php.net/downloads/pecl/releases/parallel/1.1.4/php_parallel-1.1.4-7.4-ts-vc15-x64.zip))
- Move **php_parallel.dll** to the **'xampp\php\ext\'** directory
- Move **pthreadVC2.dll** to the **'xampp\php\'** directory
- Move **pthreadVC2.dll** to the **'xampp\apache\bin'** directory
- Move **pthreadVC2.dll** to the **'C:\windows\system32'** directory
- Open **php\php.ini** and add **extension=parallel**
- Restart **XAMPP**


### Installing vendors
- Inside the project repository, open a terminal and type: **_composer install_**

### Create Database 
- Open **phpMyAdmin**, go to **Import TAB**, import file: '**_database/create_database_tables.sql_**'

### And more...
- Configure **XAMPP** for pointing to the project folder **_(Be sure to let only localhost able to access it for security reasons, at your own risks)_** 