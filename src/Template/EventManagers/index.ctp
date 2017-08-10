<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\EventManager[]|\Cake\Collection\CollectionInterface $eventManagers
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Event Manager'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="eventManagers index large-9 medium-8 columns content">
    <h3><?= __('Event Managers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('event_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('users_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_active') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventManagers as $eventManager): ?>
            <tr>
                <td><?= h($eventManager->id) ?></td>
                <td><?= $eventManager->has('event') ? $this->Html->link($eventManager->event->name, ['controller' => 'Events', 'action' => 'view', $eventManager->event->id]) : '' ?></td>
                <td><?= $eventManager->has('user') ? $this->Html->link($eventManager->user->name, ['controller' => 'Users', 'action' => 'view', $eventManager->user->id]) : '' ?></td>
                <td><?= h($eventManager->is_active) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $eventManager->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $eventManager->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $eventManager->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventManager->id)]) ?>
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
