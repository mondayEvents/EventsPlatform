<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $coupon->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $coupon->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Coupons'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="coupons form large-9 medium-8 columns content">
    <?= $this->Form->create($coupon) ?>
    <fieldset>
        <legend><?= __('Edit Coupon') ?></legend>
        <?php
            echo $this->Form->control('event_id', ['options' => $events]);
            echo $this->Form->control('code');
            echo $this->Form->control('amount');
            echo $this->Form->control('type');
            echo $this->Form->control('good_thru');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
