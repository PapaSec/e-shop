<?php $this->view("admin/header", $data); ?>
<?php $this->view("admin/sidebar", $data); ?>

<style>
    .message-cell {
        max-width: 300px;
        word-wrap: break-word;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>

<div class="container-fluid">
    <table class="table table-striped table-bordered table-hover">

        <?php if ($mode == "read"): ?>

            <a href="<?= ROOT ?>admin/blogs?add_new=true">
                <input type="button" class="btn btn-primary pull-right" value="Add new post">
            </a>

            <thead class="thead-light">
                <tr>
                    <th>Title</th>
                    <th>Owner</th>
                    <th>Post</th>
                    <th>Image</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($blogs) && is_array($blogs)): ?>
                    <?php foreach ($blogs as $blog): ?>
                        <tr>
                            <td><?= htmlspecialchars($blog->title ?? '', ENT_QUOTES) ?></td>
                            <td><a href="<?= ROOT ?>profile/<?= htmlspecialchars($blog->user_url ?? '', ENT_QUOTES) ?>"><?= htmlspecialchars($blog->user_data->name ?? '', ENT_QUOTES) ?></a></td>
                            <td><?= htmlspecialchars($blog->post ?? '', ENT_QUOTES) ?></td>
                            <td class="blog-cell"><img src="<?= ROOT . $blog->image ?>" style="width:80px;" /></td>
                            <td><?= date("jS M Y H:i a", strtotime($blog->date)) ?></td>
                            <td>
                                <a href="<?= ROOT ?>admin/blogs?edit=<?= urlencode($blog->url_address) ?>" class="btn btn-sm btn-primary">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>

                                <a href="<?= ROOT ?>admin/blogs?delete=<?= urlencode($blog->url_address) ?>" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        <?php elseif ($mode == "edit"): ?>
            <?php if (isset($errors)): ?>
                <div class="status alert alert-danger">
                    <?= $errors ?>
                </div>
            <?php endif; ?>

            <h2>Edit Post</h2>
            <form method="post" enctype="multipart/form-data">

                <label for="title">Post Title</label>
                <input type="text" class="form-control" value="<?= isset($POST['title']) ? $POST['title'] : ''; ?>" id="title" name="title">
                <br>

                <label for="image">Post Image</label>
                <input type="file" class="form-control" value="<?= isset($POST['image']) ? $POST['image'] : ''; ?>" id="image" name="image">
                <input type="hidden" name="url_address" value="<?= isset($POST['url_address']) ? $POST['url_address'] : ''; ?>">
                <br>

                <label for="post">Post Text</label>
                <textarea class="form-control" id="post" name="post"><?= isset($POST['post']) ? $POST['post'] : ''; ?></textarea>
                <br>
                <input type="submit" class="btn btn-success pull-right" value="Save">
                <hr>
                <img src="<?= ROOT ?><?= isset($POST['image']) ? $POST['image'] : ''; ?>" style="width: 200px;">
            </form>

        <?php elseif ($mode == "add_new"): ?>

            <?php if (isset($errors)): ?>
                <div class="status alert alert-danger">
                    <?= $errors ?>
                </div>
            <?php endif; ?>

            <h2>Add New Post</h2>
            <form method="post" enctype="multipart/form-data">

                <label for="title">Post Title</label>
                <input type="text" class="form-control" value="<?= isset($POST['title']) ? $POST['title'] : ''; ?>" id="title" name="title">
                <br>

                <label for="image">Post Image</label>
                <input type="file" class="form-control" value="<?= isset($POST['image']) ? $POST['image'] : ''; ?>" id="image" name="image">
                <br>

                <label for="post">Post Text</label>
                <textarea class="form-control" id="post" name="post"><?= isset($POST['post']) ? $POST['post'] : ''; ?></textarea>
                <br>
                <input type="submit" class="btn btn-success pull-right" value="Post">
            </form>

        <?php elseif ($mode == "delete_confirmed"): ?>

            <div class="status alert alert-success">
                Post deleted successfully</div>
            <a href="<?= ROOT ?>admin/blogs">
                <input type="button" class="btn btn-success pull-right" value="Back to posts">
            </a>

        <?php elseif ($mode == "delete" && is_object($blogs)): ?>
            <div class="alert alert-warning">
                Are you sure you want to delete this Post?
            </div>
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Owner</th>
                    <th>Post</th>
                    <th>Image</th>
                    <th>Date Created</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($blogs->title ?? '', ENT_QUOTES) ?></td>
                    <td><a href="<?= ROOT ?>profile/<?= htmlspecialchars($blogs->user_url ?? '', flags: ENT_QUOTES) ?>"><?= htmlspecialchars($blogs->user_data->name ?? '', ENT_QUOTES) ?></a></td>
                    <td><?= htmlspecialchars($blogs->post ?? '', ENT_QUOTES) ?></td>
                    <td class="blogs-cell"><img src="<?= ROOT . $blogs->image ?>" style="width:80px;" /></td>
                    <td><?= date("jS M Y H:i a", strtotime($blogs->date)) ?></td>
                </tr>
                <div class="mt-4">
                    <a href="<?= ROOT ?>admin/blogs?delete_confirmed=<?= urlencode($blogs->url_address) ?>" class="btn btn-danger">
                        Confirm Delete
                    </a>
                    <a href="<?= ROOT ?>admin/blogs" class="btn btn-primary">
                        Cancel
                    </a>
                </div>
                <br>
            </tbody>
    </table>


<?php endif; ?>
</table>
</div>

<?php $this->view("admin/footer", $data); ?>