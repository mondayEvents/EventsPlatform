<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Speaker $speaker
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Speaker'), ['action' => 'edit', $speaker->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Speaker'), ['action' => 'delete', $speaker->id], ['confirm' => __('Are you sure you want to delete # {0}?', $speaker->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Speakers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Speaker'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="speakers view large-9 medium-8 columns content">
    <h3><?= h($speaker->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($speaker->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($speaker->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($speaker->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($speaker->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($speaker->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Img Path') ?></th>
            <td><?= h($speaker->img_path) ?></td>
        </tr>
    </table>
</div>
