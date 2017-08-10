<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Activity[]|\Cake\Collection\CollectionInterface $activities
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Activity'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Panelists'), ['controller' => 'Panelists', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Panelist'), ['controller' => 'Panelists', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Themes'), ['controller' => 'Themes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Theme'), ['controller' => 'Themes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Event Places'), ['controller' => 'EventPlaces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event Place'), ['controller' => 'EventPlaces', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Activity Places'), ['controller' => 'ActivityPlaces', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Activity Place'), ['controller' => 'ActivityPlaces', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Concomitance'), ['controller' => 'Concomitance', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Concomitance'), ['controller' => 'Concomitance', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Registration Items'), ['controller' => 'RegistrationItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Registration Item'), ['controller' => 'RegistrationItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="activities index large-9 medium-8 columns content">
    <h3><?= __('Activities') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('event_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('panelist_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('theme_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('event_places_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activities as $activity): ?>
            <tr>
                <td><?= h($activity->id) ?></td>
                <td><?= $activity->has('event') ? $this->Html->link($activity->event->name, ['controller' => 'Events', 'action' => 'view', $activity->event->id]) : '' ?></td>
                <td><?= $activity->has('panelist') ? $this->Html->link($activity->panelist->name, ['controller' => 'Panelists', 'action' => 'view', $activity->panelist->id]) : '' ?></td>
                <td><?= $activity->has('theme') ? $this->Html->link($activity->theme->name, ['controller' => 'Themes', 'action' => 'view', $activity->theme->id]) : '' ?></td>
                <td><?= h($activity->event_places_id) ?></td>
                <td><?= h($activity->name) ?></td>
                <td><?= h($activity->description) ?></td>
                <td><?= $this->Number->format($activity->price) ?></td>
                <td><?= h($activity->type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $activity->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activity->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id)]) ?>
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
