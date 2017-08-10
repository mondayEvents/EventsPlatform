<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Activity $activity
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Activity'), ['action' => 'edit', $activity->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Activity'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Activities'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activity'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Panelists'), ['controller' => 'Panelists', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Panelist'), ['controller' => 'Panelists', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Themes'), ['controller' => 'Themes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Theme'), ['controller' => 'Themes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Event Places'), ['controller' => 'EventPlaces', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event Place'), ['controller' => 'EventPlaces', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Activity Places'), ['controller' => 'ActivityPlaces', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activity Place'), ['controller' => 'ActivityPlaces', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Concomitance'), ['controller' => 'Concomitance', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Concomitance'), ['controller' => 'Concomitance', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Registration Items'), ['controller' => 'RegistrationItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Registration Item'), ['controller' => 'RegistrationItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="activities view large-9 medium-8 columns content">
    <h3><?= h($activity->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($activity->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Event') ?></th>
            <td><?= $activity->has('event') ? $this->Html->link($activity->event->name, ['controller' => 'Events', 'action' => 'view', $activity->event->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Panelist') ?></th>
            <td><?= $activity->has('panelist') ? $this->Html->link($activity->panelist->name, ['controller' => 'Panelists', 'action' => 'view', $activity->panelist->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Theme') ?></th>
            <td><?= $activity->has('theme') ? $this->Html->link($activity->theme->name, ['controller' => 'Themes', 'action' => 'view', $activity->theme->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Event Places Id') ?></th>
            <td><?= h($activity->event_places_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($activity->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($activity->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($activity->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Price') ?></th>
            <td><?= $this->Number->format($activity->price) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Activity Places') ?></h4>
        <?php if (!empty($activity->activity_places)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Activity Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($activity->activity_places as $activityPlaces): ?>
            <tr>
                <td><?= h($activityPlaces->id) ?></td>
                <td><?= h($activityPlaces->activity_id) ?></td>
                <td><?= h($activityPlaces->name) ?></td>
                <td><?= h($activityPlaces->type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ActivityPlaces', 'action' => 'view', $activityPlaces->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ActivityPlaces', 'action' => 'edit', $activityPlaces->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ActivityPlaces', 'action' => 'delete', $activityPlaces->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activityPlaces->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Concomitance') ?></h4>
        <?php if (!empty($activity->concomitance)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Activity Id') ?></th>
                <th scope="col"><?= __('Another Activity Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($activity->concomitance as $concomitance): ?>
            <tr>
                <td><?= h($concomitance->activity_id) ?></td>
                <td><?= h($concomitance->another_activity_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Concomitance', 'action' => 'view', $concomitance->activity_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Concomitance', 'action' => 'edit', $concomitance->activity_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Concomitance', 'action' => 'delete', $concomitance->activity_id], ['confirm' => __('Are you sure you want to delete # {0}?', $concomitance->activity_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Registration Items') ?></h4>
        <?php if (!empty($activity->registration_items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Registration Id') ?></th>
                <th scope="col"><?= __('Activity Id') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($activity->registration_items as $registrationItems): ?>
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
