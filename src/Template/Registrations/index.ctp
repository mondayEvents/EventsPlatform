<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Registration[]|\Cake\Collection\CollectionInterface $registrations
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Registration'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Registration Items'), ['controller' => 'RegistrationItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Registration Item'), ['controller' => 'RegistrationItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="registrations index large-9 medium-8 columns content">
    <h3><?= __('Registrations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('event_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('when') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_paid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('total_paid') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrations as $registration): ?>
            <tr>
                <td><?= h($registration->id) ?></td>
                <td><?= $registration->has('event') ? $this->Html->link($registration->event->name, ['controller' => 'Events', 'action' => 'view', $registration->event->id]) : '' ?></td>
                <td><?= $registration->has('user') ? $this->Html->link($registration->user->name, ['controller' => 'Users', 'action' => 'view', $registration->user->id]) : '' ?></td>
                <td><?= h($registration->when) ?></td>
                <td><?= $this->Number->format($registration->is_paid) ?></td>
                <td><?= $this->Number->format($registration->total_paid) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $registration->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registration->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registration->id)]) ?>
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
