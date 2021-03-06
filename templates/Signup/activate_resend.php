<?php
$this->extend('User./base');
// breadcrumbs
$this->loadHelper('Breadcrumbs');
$this->Breadcrumbs->add(__d('user','Account Verification'));

// no robots
$this->Html->meta('robots', 'noindex,nofollow', ['block' => true]);

$this->assign('title', __d('user','Resend verification email'));
?>
<div id="user-registration-form" class="form">

    <?= $this->Form->create($user); ?>
    <?= $this->Form->control('email', ['type' => 'text', 'required' => true]); ?>
    <div class="text-right">
        <?= $this->Form->button(__d('user','Continue'), ['class' => 'btn btn-primary']); ?>
    </div>
    <?= $this->Form->end(); ?>
    <hr />
</div>