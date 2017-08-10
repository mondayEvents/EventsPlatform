<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\EventPlace $eventPlace
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Event Place'), ['action' => 'edit', $eventPlace->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Event Place'), ['action' => 'delete', $eventPlace->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventPlace->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Event Places'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Place'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="eventPlaces view large-9 medium-8 columns content">
    <h3><?= h($eventPlace->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($eventPlace->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Event') ?></th>
            <td><?= $eventPlace->has('event') ? $this->Html->link($eventPlace->event->name, ['controller' => 'Events', 'action' => 'view', $eventPlace->event->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($eventPlace->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ltd') ?></th>
            <td><?= h($eventPlace->ltd) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lat') ?></th>
            <td><?= h($eventPlace->lat) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lng') ?></th>
            <td><?= h($eventPlace->lng) ?></td>
        </tr>
    </table>
</div>
