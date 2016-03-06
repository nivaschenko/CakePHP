<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Message'), ['action' => 'edit', $message->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Message'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Messages'), ['controller' => 'Messages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Message'), ['controller' => 'Messages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="messages view large-9 medium-8 columns content">
    <h3><?= h($message->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Title') ?></th>
            <td><?= h($message->title) ?></td>
        </tr>
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $message->has('user') ? $this->Html->link($message->user->id, ['controller' => 'Users', 'action' => 'view', $message->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Lat') ?></th>
            <td><?= h($message->lat) ?></td>
        </tr>
        <tr>
            <th><?= __('Lng') ?></th>
            <td><?= h($message->lng) ?></td>
        </tr>
        <tr>
            <th><?= __('Type') ?></th>
            <td><?= h($message->type) ?></td>
        </tr>
        <tr>
            <th><?= __('Message Id') ?></th>
            <td><?= h($message->message_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($message->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($message->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($message->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($message->message)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Messages') ?></h4>
        <?php if (!empty($message->messages)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Message') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Lat') ?></th>
                <th><?= __('Lng') ?></th>
                <th><?= __('Type') ?></th>
                <th><?= __('Message Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($message->messages as $messages): ?>
            <tr>
                <td><?= h($messages->id) ?></td>
                <td><?= h($messages->title) ?></td>
                <td><?= h($messages->message) ?></td>
                <td><?= h($messages->user_id) ?></td>
                <td><?= h($messages->lat) ?></td>
                <td><?= h($messages->lng) ?></td>
                <td><?= h($messages->type) ?></td>
                <td><?= h($messages->message_id) ?></td>
                <td><?= h($messages->created) ?></td>
                <td><?= h($messages->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Messages', 'action' => 'view', $messages->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Messages', 'action' => 'edit', $messages->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Messages', 'action' => 'delete', $messages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $messages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
