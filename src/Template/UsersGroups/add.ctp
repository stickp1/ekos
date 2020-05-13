<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UsersGroup $usersGroup
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users Groups'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Groups'), ['controller' => 'Groups', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Group'), ['controller' => 'Groups', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="usersGroups form large-9 medium-8 columns content">
    <?= $this->Form->create($usersGroup) ?>
    <fieldset>
        <legend><?= __('Add Users Group') ?></legend>
        <?php
            echo $this->Form->control('groups_id');
            echo $this->Form->control('groups_courses_id', ['options' => $groups, 'empty' => true]);
            echo $this->Form->control('users_id', ['options' => $users, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
