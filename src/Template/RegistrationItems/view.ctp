<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\RegistrationItem $registrationItem
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Registration Item'), ['action' => 'edit', $registrationItem->registration_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Registration Item'), ['action' => 'delete', $registrationItem->registration_id], ['confirm' => __('Are you sure you want to delete # {0}?', $registrationItem->registration_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Registration Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registration Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Registrations'), ['controller' => 'Registrations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registration'), ['controller' => 'Registrations', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Activities'), ['controller' => 'Activities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activity'), ['controller' => 'Activities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="registrationItems view large-9 medium-8 columns content">
    <h3><?= h($registrationItem->registration_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Registration') ?></th>
            <td><?= $registrationItem->has('registration') ? $this->Html->link($registrationItem->registration->id, ['controller' => 'Registrations', 'action' => 'view', $registrationItem->registration->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Activity') ?></th>
            <td><?= $registrationItem->has('activity') ? $this->Html->link($registrationItem->activity->name, ['controller' => 'Activities', 'action' => 'view', $registrationItem->activity->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($registrationItem->price) ?></td>
        </tr>
    </table>
</div>
