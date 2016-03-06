<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if ( is_array($menu) ) {
                foreach ( $menu as $point => $link ) {
                    echo '<li>' . $this->Html->link(__($point), ['controller' => $link['controller'], 'action' => $link['action']]) . '</li>';
                }
            }
        ?>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">

    <?= $this->Form->create($user) ?>
        <fieldset>
            <legend><?= __('Add User') ?></legend>
            <?= $this->Form->input('username') ?>
            <?= $this->Form->input('email') ?>
            <?= $this->Form->input('password') ?>
            <?= $this->Form->input('role', [
                'options' => ['admin' => 'Admin', 'user' => 'User']
            ]) ?>
       </fieldset>
    <?= $this->Form->button(__('Submit')); ?>
    <?= $this->Form->end() ?>
</div>
</div>
