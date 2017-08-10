<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Event $event
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Event'), ['action' => 'edit', $event->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Event'), ['action' => 'delete', $event->id], ['confirm' => __('Are you sure you want to delete # {0}?', $event->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Events'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Event'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="events view large-9 medium-8 columns content">
    <h3><?= h($event->name) ?></h3>
    <table class="vertical-table">

        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $event->has('user') ? $this->Html->link($event->user->name, ['controller' => 'Users', 'action' => 'view', $event->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tags') ?></th>
            <td><?= h($event->tags) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Starts at') ?></th>
            <td><?= h($event->date_start) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ends at') ?></th>
            <td><?= h($event->date_end) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4>
            <?= __('Activities') ?>
            <?php if ($isOwner): ?>
                <span style="font-size: 16px; display: inline-block; margin-left: 20px;">
                    <?= $this->Html->link(__('Add Activity'), ['controller' => 'Activities', 'action' => 'add', $event->id]) ?>
                </span>
            <?php endif; ?>
        </h4>
        <?php if (!empty($event->activities)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Panelist') ?></th>
                <th scope="col"><?= __('Theme Id') ?></th>
                <th scope="col"><?= __('Event Places') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Price') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->activities as $activities): ?>
            <tr>
                <td><?= h($activities->id) ?></td>
                <td><?= h($activities->panelist->name) ?></td>
                <td><?= h($activities->theme_id) ?></td>
                <td><?= h($activities->event_place->name) ?></td>
                <td><?= h($activities->name) ?></td>
                <td><?= h($activities->description) ?></td>
                <td><?= h($activities->price) ?></td>
                <td><?= h($activities->type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Activities', 'action' => 'view', $activities->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Activities', 'action' => 'edit', $activities->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Activities', 'action' => 'delete', $activities->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activities->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4>
            <?= __('Coupons') ?>
            <?php if ($isOwner): ?>
            <span style="font-size: 16px; display: inline-block; margin-left: 20px;">
                <?= $this->Html->link(__('Add Coupon'), ['controller' => 'Coupons', 'action' => 'add', $event->id]) ?>
            </span>
            <?php endif; ?>
        </h4>
        <?php if (!empty($event->coupons)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Event Id') ?></th>
                <th scope="col"><?= __('Code') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Good Thru') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->coupons as $coupons): ?>
            <tr>
                <td><?= h($coupons->id) ?></td>
                <td><?= h($coupons->event_id) ?></td>
                <td><?= h($coupons->code) ?></td>
                <td><?= h($coupons->amount) ?></td>
                <td><?= h($coupons->type) ?></td>
                <td><?= h($coupons->good_thru) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Coupons', 'action' => 'view', $coupons->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Coupons', 'action' => 'edit', $coupons->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Coupons', 'action' => 'delete', $coupons->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coupons->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4>
            <?= __('Related Event') ?>
            <?php if ($isOwner): ?>
                <span style="font-size: 16px; display: inline-block; margin-left: 20px;">
                    <?= $this->Html->link(__('Add Event Association'), ['controller' => 'EventAssociations', 'action' => 'add', $event->id]) ?>
                </span>
            <?php endif; ?>
        </h4>
        <?php if (!empty($event->event_associations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Event Id') ?></th>
                <th scope="col"><?= __('Subevent Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->event_associations as $eventAssociations): ?>
            <tr>
                <td><?= h($eventAssociations->event_id) ?></td>
                <td><?= h($eventAssociations->subevent_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EventAssociations', 'action' => 'view', $eventAssociations->event_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EventAssociations', 'action' => 'edit', $eventAssociations->event_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EventAssociations', 'action' => 'delete', $eventAssociations->event_id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventAssociations->event_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>

    <?php if ($isOwner): ?>
        <div class="related">
            <h4>
                <?= __('Registrations') ?>
                <span style="font-size: 16px; display: inline-block; margin-left: 20px;">
                    <?= $this->Html->link(__('List Registrations'), ['controller' => 'Registrations', 'action' => 'index', $event->id]) ?>
                </span>
            </h4>
            <?php if (!empty($event->registrations)): ?>
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <th scope="col"><?= __('Id') ?></th>
                    <th scope="col"><?= __('Event Id') ?></th>
                    <th scope="col"><?= __('User Id') ?></th>
                    <th scope="col"><?= __('When') ?></th>
                    <th scope="col"><?= __('Is Paid') ?></th>
                    <th scope="col"><?= __('Total Paid') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
                <?php foreach ($event->registrations as $registrations): ?>
                <tr>
                    <td><?= h($registrations->id) ?></td>
                    <td><?= h($registrations->event_id) ?></td>
                    <td><?= h($registrations->user_id) ?></td>
                    <td><?= h($registrations->when) ?></td>
                    <td><?= h($registrations->is_paid) ?></td>
                    <td><?= h($registrations->total_paid) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Registrations', 'action' => 'view', $registrations->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Registrations', 'action' => 'edit', $registrations->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Registrations', 'action' => 'delete', $registrations->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registrations->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="related">
        <h4>
            <?= __('Sponsorships') ?>
            <?php if ($isOwner): ?>
                <span style="font-size: 16px; display: inline-block; margin-left: 20px;">
                    <?= $this->Html->link(__('Add Sponsorship'), ['controller' => 'Sponsorships', 'action' => 'add', $event->id]) ?>
                </span>
            <?php endif; ?>
        </h4>
        <?php if (!empty($event->sponsorships)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Event Id') ?></th>
                <th scope="col"><?= __('Company Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->sponsorships as $sponsorships): ?>
            <tr>
                <td><?= h($sponsorships->event_id) ?></td>
                <td><?= h($sponsorships->company_id) ?></td>
                <td><?= h($sponsorships->type) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Sponsorships', 'action' => 'view', $sponsorships->event_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Sponsorships', 'action' => 'edit', $sponsorships->event_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Sponsorships', 'action' => 'delete', $sponsorships->event_id], ['confirm' => __('Are you sure you want to delete # {0}?', $sponsorships->event_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4>
            <?= __('Event Managers') ?>
            <?php if ($isOwner): ?>
                <span style="font-size: 16px; display: inline-block; margin-left: 20px;">
                    <?= $this->Html->link(__('Add Event Manager'), ['controller' => 'EventManagers', 'action' => 'add', $event->id]) ?>
                </span>
            <?php endif; ?>
        </h4>
        <?php if (!empty($event->event_managers)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Event Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Is Active') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->event_managers as $eventManagers): ?>
            <tr>
                <td><?= h($eventManagers->id) ?></td>
                <td><?= h($eventManagers->event_id) ?></td>
                <td><?= h($eventManagers->user_id) ?></td>
                <td><?= h($eventManagers->is_active) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EventManagers', 'action' => 'view', $eventManagers->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EventManagers', 'action' => 'edit', $eventManagers->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EventManagers', 'action' => 'delete', $eventManagers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventManagers->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
