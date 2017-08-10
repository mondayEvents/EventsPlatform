<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\EventPlace[]|\Cake\Collection\CollectionInterface $eventPlaces
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Event Place'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="eventPlaces index large-9 medium-8 columns content">
    <h3><?= __('Event Places') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('events_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ltd') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lat') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lng') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventPlaces as $eventPlace): ?>
            <tr>
                <td><?= h($eventPlace->id) ?></td>
                <td><?= $eventPlace->has('event') ? $this->Html->link($eventPlace->event->name, ['controller' => 'Events', 'action' => 'view', $eventPlace->event->id]) : '' ?></td>
                <td><?= h($eventPlace->name) ?></td>
                <td><?= h($eventPlace->ltd) ?></td>
                <td><?= h($eventPlace->lat) ?></td>
                <td><?= h($eventPlace->lng) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $eventPlace->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $eventPlace->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $eventPlace->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventPlace->id)]) ?>
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
