$sql = "CREATE USER \'user1\'@\'localhost\' IDENTIFIED WITH mysql_native_password AS \'***\'GRANT ALL PRIVILEGES ON *.* TO \'user1\'@\'localhost\' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";