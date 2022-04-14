<?php include_once './header.php'; ?>
<?php include_once './cred_db.php'; ?>

    <body>
        <?php include_once './navbar.php'; ?>
        <div class="container mt-3"> 
            <?php 
                $conn = sqlsrv_connect(SERVER_NAME, ['Database' => DATABASE_NAME]);
                
                // 1 = 0 * 10 = 0
                // 2 = 1 * 10 = 10
                // 3 = 2 * 10 = 20

                $offset = (($_GET['page'] ?? 1) - 1) * 10;
                
                // if (isset($_GET['page'])) {
                //     $offset = $_GET['page']
                // } else {
                //     $offset = 1;
                // }
                

                $select_all_posts = "SELECT * FROM posts ORDER BY id OFFSET ? ROWS FETCH FIRST 10 ROWS ONLY;";
                $stmt = sqlsrv_prepare($conn, $select_all_posts, [$offset]);
                sqlsrv_execute($stmt);
                if (!$stmt) {
                    echo '
                        <div class="alert alert-warning" role="alert">
                            No posts!
                        </div>
                    ';
                    exit;
                }
            ?>

            <div class="alert alert-info" role="alert">
                <?php 
                    $count_posts_sql = "SELECT count(*) as post_count FROM posts";
                    $stmt_count = sqlsrv_query($conn, $count_posts_sql);
                    $posts_count = sqlsrv_fetch_array($stmt_count, SQLSRV_FETCH_ASSOC)['post_count'];
                    $number_of_pages = ceil($posts_count / 10);
                    $page = $_GET['page'] ?? 1;
                ?>
                We have <?= $posts_count ?> posts!
            </div>
            <div class="row">
                <?php while($product = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['title']); ?></h5>
                                <p class="card-text text-truncate">
                                    <?= htmlspecialchars($product['body']); ?>
                                </p>
                                <a href="./post.php?id=<?= $product['id']; ?>" class="btn btn-primary">See deatils</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <nav>
                <ul class="pagination">
                    <?php for ($i=0; $i < $number_of_pages; $i++): ?>
                        <li class="page-item <?= $page == $i + 1 ? 'active' : '' ?>">
                            <a class="page-link" href="./posts.php?page=<?= $i + 1; ?>"><?= $i + 1; ?></a>
                        </li>                        
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </body>

</html>