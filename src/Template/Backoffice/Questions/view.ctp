<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Question $question
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Question'), ['action' => 'edit', $question->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $question->id], ['confirm' => __('Are you sure you want to delete # {0}?', $question->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Questions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Question'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Exams'), ['controller' => 'Exams', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Exam'), ['controller' => 'Exams', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Themes'), ['controller' => 'Themes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Theme'), ['controller' => 'Themes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="questions view large-9 medium-8 columns content">
    <h3><?= h($question->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Exam') ?></th>
            <td><?= $question->has('exam') ? $this->Html->link($question->exam->name, ['controller' => 'Exams', 'action' => 'view', $question->exam->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Correct') ?></th>
            <td><?= h($question->correct) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Theme') ?></th>
            <td><?= $question->has('theme') ? $this->Html->link($question->theme->name, ['controller' => 'Themes', 'action' => 'view', $question->theme->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($question->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Course Id') ?></th>
            <td><?= $this->Number->format($question->course_id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Op1') ?></h4>
        <?= $this->Text->autoParagraph(h($question->op1)); ?>
    </div>
    <div class="row">
        <h4><?= __('Op2') ?></h4>
        <?= $this->Text->autoParagraph(h($question->op2)); ?>
    </div>
    <div class="row">
        <h4><?= __('Op3') ?></h4>
        <?= $this->Text->autoParagraph(h($question->op3)); ?>
    </div>
    <div class="row">
        <h4><?= __('Op4') ?></h4>
        <?= $this->Text->autoParagraph(h($question->op4)); ?>
    </div>
    <div class="row">
        <h4><?= __('Op5') ?></h4>
        <?= $this->Text->autoParagraph(h($question->op5)); ?>
    </div>
    <div class="row">
        <h4><?= __('Justification') ?></h4>
        <?= $this->Text->autoParagraph(h($question->justification)); ?>
    </div>
    <div class="row">
        <h4><?= __('Question') ?></h4>
        <?= $this->Text->autoParagraph(h($question->question)); ?>
    </div>
</div>
