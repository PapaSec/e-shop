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
            <thead class="thead-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th class="message-cell">Message</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($messages) && is_array($messages)): ?>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?= htmlspecialchars($message->name ?? '', ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($message->email ?? '', ENT_QUOTES) ?></td>
                            <td><?= htmlspecialchars($message->subject ?? '', ENT_QUOTES) ?></td>
                            <td class="message-cell"><?= nl2br(htmlspecialchars($message->message ?? '', ENT_QUOTES)) ?></td>
                            <td><?= date("jS M Y H:i a", strtotime($message->date)) ?></td>
                            <td>
                                <a href="<?= ROOT ?>admin/messages?delete=<?= urlencode($message->id) ?>" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>

        <?php elseif ($mode == "delete_confirmed"): ?>
            <div class="alert alert-success alert-dismissible fade show">
                Message deleted successfully
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <a href="<?= ROOT ?>admin/messages" class="btn btn-outline-primary">
                Back to messages
            </a>

        <?php elseif ($mode == "delete" && is_object($messages)): ?>
            <div class="alert alert-warning">
                Are you sure you want to delete this message?
            </div>

            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($messages->name ?? '', ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($messages->email ?? '', ENT_QUOTES) ?></td>
                        <td><?= htmlspecialchars($messages->subject ?? '', ENT_QUOTES) ?></td>
                        <td class="message-cell"><?= nl2br(htmlspecialchars($messages->message ?? '', ENT_QUOTES)) ?></td>
                        <td><?= date("jS M Y H:i a", strtotime($messages->date)) ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <a href="<?= ROOT ?>admin/messages?delete_confirmed=<?= urlencode($messages->id) ?>" class="btn btn-danger">
                    Confirm Delete
                </a>
                <a href="<?= ROOT ?>admin/messages" class="btn btn-secondary">
                    Cancel
                </a>
            </div>
        <?php endif; ?>
    </table>
</div>

<?php $this->view("admin/footer", $data); ?>