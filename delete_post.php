<?php 

// TODO check if the user can delete 

include_once './cred_db.php';
$id = $_GET['id'];
$conn = sqlsrv_connect(SERVER_NAME, ['Database' => DATABASE_NAME]);

$sql_delete_post = "DELETE posts WHERE id = ?";
$stmt = sqlsrv_prepare($conn, $sql_delete_post, [$id]);
sqlsrv_execute($stmt);

// print_r(sqlsrv_errors());
if ($stmt) {
    // print_r($stmt);
    header("Location: posts.php");
    exit;
} else {
    echo "Something went wrong";
}