<?php include_once './header.php'; ?>
<?php include_once './cred_db.php'; ?>

    <body>
        <?php include_once './navbar.php'; ?>
        <?php 
            $id = $_GET['id'];
            $conn = sqlsrv_connect(SERVER_NAME, ['Database' => DATABASE_NAME]);
            $select_post_by_id = "SELECT * FROM posts WHERE id = ?";
            $stmt = sqlsrv_prepare($conn, $select_post_by_id, [$id]);
            sqlsrv_execute($stmt);
            $post = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        ?>

        <?php if($post): ?>
            <div class="card">
                <div class="card-header">
                    post id = <?= $post['id']; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title">
                        <?= htmlspecialchars($post['id']); ?>
                    </h5>
                    <p class="card-text">
                        <?= htmlspecialchars($post['body']); ?>
                    </p>
                    <a href="./delete_post.php?id=<?= $post['id']; ?>" class="btn btn-danger">Delete</a>
                    <a href="./update_post.php?id=<?= $post['id']; ?>" class="btn btn-warning">Edit</a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Not found 404
            </div>  
        <?php endif; ?>
    </body>

</html>