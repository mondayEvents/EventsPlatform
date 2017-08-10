<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\EventManager $eventManager
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Event Manager'), ['action' => 'edit', $eventManager->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Event Manager'), ['action' => 'delete', $eventManager->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventManager->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Event Managers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Manager'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="eventManagers view large-9 medium-8 columns content">
    <h3><?= h($eventManager->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($eventManager->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Event') ?></th>
            <td><?= $eventManager->has('event') ? $this->Html->link($eventManager->event->name, ['controller' => 'Events', 'action' => 'view', $eventManager->event->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $eventManager->has('user') ? $this->Html->link($eventManager->user->name, ['controller' => 'Users', 'action' => 'view', $eventManager->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $eventManager->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
