<?php 

include './cred_db.php';

// use mysqli
$conn = sqlsrv_connect(SERVER_NAME, ['Database' => DATABASE_NAME]);


function attach_create_if_not_exists ($sql_str, $table_name) {
    return "
        IF OBJECT_ID(N'dbo.$table_name', N'U') IS NULL BEGIN
            $sql_str
        END;
    ";
}


$tables = [
    'posts' => "
            CREATE TABLE posts (
                id int IDENTITY(1,1) PRIMARY KEY,
                body text NOT NULL,
                title VARCHAR(255) NOT NULL
            );
    ",
    'comments' => "
            CREATE TABLE comments (
                id int IDENTITY(1,1) PRIMARY KEY,
                body VARCHAR(255) NOT NULL,
                post_id int NOT NULL,
                FOREIGN KEY (post_id) REFERENCES posts(id)
            );
    "
];


foreach ($tables as $table_name => $sql) {
    $stmt = sqlsrv_query($conn, attach_create_if_not_exists($sql, $table_name));
    if ($stmt) {
        print("✅ created {$table_name}\n");
    } else {
        print("❌ error while creating => {$table_name}");
        print_r(sqlsrv_errors());
    }
}