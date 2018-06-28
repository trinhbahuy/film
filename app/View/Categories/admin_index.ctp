<h1>Categories List</h1>
<p><?php echo $this->Html->link('Add Category', array('action' => 'admin_add')); ?></p>

<table class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
        <tr>
            <td><?php echo $cat['Category']['id']; ?></td>
            <td>
                <?php echo $cat['Category']['category_name']; ?>
            </td>
            <td>
                <?php
                    echo $this->Form->postLink(
                        'Delete',
                        array('action' => 'admin_delete', $cat['Category']['id']),
                        array('confirm' => 'Are you sure?, Yeah, why not!')
                    );
                ?>
                <?php
                    echo $this->Html->link(
                        'Edit', array('action' => 'admin_edit', $cat['Category']['id'])
                    );
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>