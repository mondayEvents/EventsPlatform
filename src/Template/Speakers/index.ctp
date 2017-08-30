<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Speaker[]|\Cake\Collection\CollectionInterface $speakers
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Speaker'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="speakers index large-9 medium-8 columns content">
    <h3><?= __('Speakers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('url') ?></th>
                <th scope="col"><?= $this->Paginator->sort('img_path') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($speakers as $speaker): ?>
            <tr>
                <td><?= h($speaker->id) ?></td>
                <td><?= h($speaker->name) ?></td>
                <td><?= h($speaker->description) ?></td>
                <td><?= h($speaker->email) ?></td>
                <td><?= h($speaker->url) ?></td>
                <td><?= h($speaker->img_path) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $speaker->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $speaker->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $speaker->id], ['confirm' => __('Are you sure you want to delete # {0}?', $speaker->id)]) ?>
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
