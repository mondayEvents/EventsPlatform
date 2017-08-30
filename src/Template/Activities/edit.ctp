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
                ['action' => 'delete', $activity->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Activities'), ['action' => 'index']) ?></li>
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
<div class="activities form large-9 medium-8 columns content">
    <?= $this->Form->create($activity) ?>
    <fieldset>
        <legend><?= __('Edit Activity') ?></legend>
        <?php
            echo $this->Form->control('event_id', ['options' => $events]);
            echo $this->Form->control('panelist_id', ['options' => $panelists]);
            echo $this->Form->control('theme_id', ['options' => $themes, 'empty' => true]);
            echo $this->Form->control('event_places_id');
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('price');
            echo $this->Form->control('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
