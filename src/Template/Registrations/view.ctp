<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Registration $registration
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Registration'), ['action' => 'edit', $registration->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Registration'), ['action' => 'delete', $registration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registration->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Registrations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registration'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Registration Items'), ['controller' => 'RegistrationItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registration Item'), ['controller' => 'RegistrationItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="registrations view large-9 medium-8 columns content">
    <h3><?= h($registration->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($registration->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Event') ?></th>
            <td><?= $registration->has('event') ? $this->Html->link($registration->event->name, ['controller' => 'Events', 'action' => 'view', $registration->event->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $registration->has('user') ? $this->Html->link($registration->user->name, ['controller' => 'Users', 'action' => 'view', $registration->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Paid') ?></th>
            <td><?= $this->Number->format($registration->is_paid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Paid') ?></th>
            <td><?= $this->Number->format($registration->total_paid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('When') ?></th>
            <td><?= h($registration->when) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Registration Items') ?></h4>
        <?php if (!empty($registration->registration_items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Registration Id') ?></th>
                <th scope="col"><?= __('Activity Id') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($registration->registration_items as $registrationItems): ?>
            <tr>
                <td><?= h($registrationItems->registration_id) ?></td>
                <td><?= h($registrationItems->activity_id) ?></td>
                <td><?= h($registrationItems->price) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'RegistrationItems', 'action' => 'view', $registrationItems->registration_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'RegistrationItems', 'action' => 'edit', $registrationItems->registration_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'RegistrationItems', 'action' => 'delete', $registrationItems->registration_id], ['confirm' => __('Are you sure you want to delete # {0}?', $registrationItems->registration_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
