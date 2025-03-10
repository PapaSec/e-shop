<?php $this->view("admin/header", $data); ?>

<?php $this->view("admin/sidebar", $data); ?>

<style>
    .details {

        background-color: #eee;
        padding: 10px;
        box-shadow: 0px 0px 10px #aaa;
        width: 100%;
        position: absolute;
        min-height: 100px;
        z-index: 2;
        left: 0px;
    }
</style>

<table class="table table-striped table-advance table-header">

    <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Orders #</th>
            <th>Date Created</th>
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($users) && is_array($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr style="position: relative;">
                    <td><?= $user->id ?></td>
                    <td><a href="<?= ROOT ?>profile/<?= $user->url_address ?>"><?= $user->name ?></a></td>
                    <td><?= $user->email ?></td>
                    <td>
                        <?= $user->orders_count ?>
                    </td>
                    <td><?= date("jS M Y H:i a", strtotime($user->date)) ?></td>

                    </div>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>


<?php $this->view("admin/footer", $data); ?>