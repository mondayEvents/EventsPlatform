<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Company $company
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Company'), ['action' => 'edit', $company->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Company'), ['action' => 'delete', $company->id], ['confirm' => __('Are you sure you want to delete # {0}?', $company->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Companies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Company'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sponsorships'), ['controller' => 'Sponsorships', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sponsorship'), ['controller' => 'Sponsorships', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="companies view large-9 medium-8 columns content">
    <h3><?= h($company->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($company->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($company->company) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Logo') ?></th>
            <td><?= h($company->logo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Site') ?></th>
            <td><?= h($company->site) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Sponsorships') ?></h4>
        <?php if (!empty($company->sponsorships)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Event Id') ?></th>
                <th scope="col"><?= __('Company Id') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($company->sponsorships as $sponsorships): ?>
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
</div>
