<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Speakers'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="speakers form large-9 medium-8 columns content">
    <?= $this->Form->create($speaker) ?>
    <fieldset>
        <legend><?= __('Add Speaker') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('email');
            echo $this->Form->control('url');
            echo $this->Form->control('img_path');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
