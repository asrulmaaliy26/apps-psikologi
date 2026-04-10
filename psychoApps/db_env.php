<?php

if (!function_exists('psycho_db_config')) {
    /**
     * Kredensial DB: lokal default root + password kosong.
     * Docker: set DB_HOST=db, DB_USER=root, DB_PASSWORD=root (lihat docker-compose.yml).
     *
     * @return array{0: string, 1: string, 2: string, 3: string} server, user, password, database
     */
    function psycho_db_config(string $dbname): array
    {
        $dbserver = getenv('DB_HOST');
        $dbserver = ($dbserver === false || $dbserver === '') ? 'localhost' : $dbserver;

        $dbusername = getenv('DB_USER');
        $dbusername = ($dbusername === false || $dbusername === '') ? 'root' : $dbusername;

        if (getenv('DB_PASSWORD') !== false) {
            $dbpassword = (string) getenv('DB_PASSWORD');
        } else {
            $dbpassword = '';
        }

        return [$dbserver, $dbusername, $dbpassword, $dbname];
    }
}
