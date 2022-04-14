<?php include_once './cred_db.php'; ?>
<?php include_once './header.php'; ?>

<body>
    <?php include_once './navbar.php'; ?>
    <div class="container mt-3">
        <?php if (isset($_POST['post_data'])): ?>
            <?php 
                $conn = sqlsrv_connect(SERVER_NAME, ['Database' => DATABASE_NAME]);
                $sql_update_post = '
                    UPDATE posts SET "body" = ?, "title" = ? WHERE id = ?;
                ';
                $body = $_POST['body'];
                $title = $_POST['title'];
                $id = $_POST['id'];
                $prepared_stmt = sqlsrv_prepare($conn, $sql_update_post, [$body, $title, $id]);
            ?>

            <?php if (sqlsrv_execute($prepared_stmt)): ?>
                <div class="alert alert-success" role="alert">
                    Updated!
                </div>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Something went wrong while creating your post, please try again later                
                    <pre>
                        <?php print_r(sqlsrv_errors()); ?>
                    </pre>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php 
                $id = $_GET['id'];
                $conn = sqlsrv_connect(SERVER_NAME, ['Database' => DATABASE_NAME]);
                $select_post_by_id = "SELECT * FROM posts WHERE id = ?";
                $stmt = sqlsrv_prepare($conn, $select_post_by_id, [$id]);
                sqlsrv_execute($stmt);
                $post = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            ?>
            <form action="update_post.php" method="post">
                <div class="mb-3">
                    <label for="post-title" class="form-label">Post title</label>
                    <input type="text" class="form-control" id="post-title" name="title" value="<?= htmlspecialchars($post['title']); ?>" placeholder="Post title">
                </div>
                <input name="id" hidden value="<?= $post['id']; ?>" />
                <div class="mb-3">
                    <label for="post-body" class="form-label">Body</label>
                    <textarea class="form-control" id="post-body" name="body" rows="10">
                        <?= htmlspecialchars($post['body']); ?>
                    </textarea>
                </div>
                <button type="submit" name="post_data" class="btn btn-primary mb-3">Update post</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>