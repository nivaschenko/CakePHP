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
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('email');
            echo $this->Form->input('role', [
                'options' => ['admin' => 'Admin', 'user' => 'User']
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
