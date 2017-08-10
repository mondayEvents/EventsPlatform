<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\RegistrationItem[]|\Cake\Collection\CollectionInterface $registrationItems
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Registration Item'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Registrations'), ['controller' => 'Registrations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Registration'), ['controller' => 'Registrations', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Activities'), ['controller' => 'Activities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Activity'), ['controller' => 'Activities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="registrationItems index large-9 medium-8 columns content">
    <h3><?= __('Registration Items') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('registration_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('activity_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registrationItems as $registrationItem): ?>
            <tr>
                <td><?= $registrationItem->has('registration') ? $this->Html->link($registrationItem->registration->id, ['controller' => 'Registrations', 'action' => 'view', $registrationItem->registration->id]) : '' ?></td>
                <td><?= $registrationItem->has('activity') ? $this->Html->link($registrationItem->activity->name, ['controller' => 'Activities', 'action' => 'view', $registrationItem->activity->id]) : '' ?></td>
                <td><?= $this->Number->format($registrationItem->price) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $registrationItem->registration_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registrationItem->registration_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registrationItem->registration_id], ['confirm' => __('Are you sure you want to delete # {0}?', $registrationItem->registration_id)]) ?>
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
