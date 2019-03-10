<?php $this->assign('heading', 'User Mailer'); ?>
<div class="index">

    <p>
        <?= $this->Html->link(__('Back'), ['controller' => 'Dashboard', 'action' => 'users']); ?> |
        <?= $this->Html->link(__('Edit User'), ['controller' => 'Users', 'action' => 'edit', $user->id]); ?>
    </p>

    <?= $this->Form->create(null); ?>
    <?= $this->Form->input('user_id', ['type' => 'text', 'readonly' => true, 'value' => $user->id]); ?>
    <?= $this->Form->input('email', ['type' => 'text', 'readonly' => true, 'value' => $user->email]); ?>
    <?= $this->Form->input('email_type', [
        'type' => 'select',
        'options' => $emailTypes
    ]); ?>

    <?= $this->Form->input('debug_only', [
        'type' => 'checkbox',
        'checked' => 'checked'
    ]); ?>

    <?= $this->Form->submit(); ?>

    <?php if (isset($result)): ?>
        <h2>Email Result</h2>

        <?php if (isset($result['headers'])): ?>
            <h4>Email Result</h4>
            <pre><?= h($result['headers']); ?></pre>
        <?php endif; ?>

        <?php if (isset($result['message'])): ?>
            <h4>Email Result</h4>
            <div class="email-message" style="border: 1px solid red;">
                <?= $result['message']; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php debug($user); ?>
</div>