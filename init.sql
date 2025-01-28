CREATE USER IF NOT EXISTS 'laravel-user'@'%' IDENTIFIED BY 'securepassword';
GRANT ALL PRIVILEGES ON laravel.* TO 'laravel-user'@'%';
FLUSH PRIVILEGES;
