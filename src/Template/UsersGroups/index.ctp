<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersGroup[]|\Cake\Collection\CollectionInterface $usersGroups
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Users Group'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usersGroups index large-9 medium-8 columns content">
    <h3><?= __('Users Groups') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('groups_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('groups_courses_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('users_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersGroups as $usersGroup): ?>
            <tr>
                <td><?= $this->Number->format($usersGroup->id) ?></td>
                <td><?= $this->Number->format($usersGroup->groups_id) ?></td>
                <td><?= $usersGroup->has('group') ? $this->Html->link($usersGroup->group->name, ['controller' => 'Groups', 'action' => 'view', $usersGroup->group->id]) : '' ?></td>
                <td><?= $usersGroup->has('user') ? $this->Html->link($usersGroup->user->name, ['controller' => 'Users', 'action' => 'view', $usersGroup->user->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $usersGroup->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $usersGroup->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $usersGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $usersGroup->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
