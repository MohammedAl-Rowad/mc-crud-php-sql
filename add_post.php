<?php include_once './cred_db.php'; ?>

<div class="container mt-3">
    <?php if(isset($_POST['post_data'])): ?>
        <?php 
            $conn = sqlsrv_connect(SERVER_NAME, ['Database' => DATABASE_NAME]);
            $sql_insert_post = '
                INSERT INTO posts ("body", "title") VALUES (?, ?);
            ';
            $body = $_POST['body'];
            $title = $_POST['title'];
            $prepared_stmt = sqlsrv_prepare($conn, $sql_insert_post, [$body, $title]);
        ?>
        <?php if (sqlsrv_execute($prepared_stmt)): ?>
            <div class="alert alert-success" role="alert">
                Created!
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
        <form action="index.php" method="post">
            <div class="mb-3">
                <label for="post-title" class="form-label">Post title</label>
                <input type="text" class="form-control" id="post-title" name="title" placeholder="Post title">
            </div>
            <div class="mb-3">
                <label for="post-body" class="form-label">Body</label>
                <textarea class="form-control" id="post-body" name="body" rows="10"></textarea>
            </div>
            <button type="submit" name="post_data" class="btn btn-primary mb-3">Create post</button>
        </form>
    <?php endif; ?>
 

</div>