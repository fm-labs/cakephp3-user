<!DOCTYPE html>
<html lang="<?= Cake\I18n\I18n::getLocale(); ?>">
<head>
    <?= $this->Html->charset() ?>
    <title><?= $this->fetch('title') ?></title>
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="robots" content="noindex,nofollow">
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>

    <?= $this->Html->css('User.user'); ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('headjs') ?>
</head>
<body>
<header>
</header>
<div id="page">
    <div id="flash" class="container">
        <?= $this->Flash->render(); ?>
        <?= $this->Flash->render('auth'); ?>
        <?= $this->fetch('flash') ?>
    </div>
    <main id="main" class="container">
        <?= $this->fetch('content') ?>
    </main>
    <footer>
    </footer>
</div>
<?= $this->fetch('script') ?>
</body>
</html>
