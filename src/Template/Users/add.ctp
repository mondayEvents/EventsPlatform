<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Events'), ['controller' => 'Events', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Event'), ['controller' => 'Events', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            $this->Form->templates(['dateWidget' => '{{day}}{{month}}{{year}}']);

            echo $this->Form->control('name');
            echo $this->Form->control('birthdate',
                [
                    'type' => 'date',
                    'minYear' => date('Y') - 70,
                    'maxYear' => date('Y') - 1
                ]
            );
            echo $this->Form->input('birthdate.hour', ['type' => 'hidden', 'value' => '00']);
            echo $this->Form->input('birthdate.minute', ['type' => 'hidden', 'value' => '00']);

            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('tags', ['label' =>  'What topics are interested in?']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
