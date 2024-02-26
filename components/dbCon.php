<?php
class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('../sqlite_database/event.sqlite3');
    }
}
$db = new MyDB();
