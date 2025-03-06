<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="/assets/js/color-modes.js"></script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Sistem Informasi Penerimaan Peserta Didik Baru" />
    <meta name="creator" content="muhsaidlg.my.id" />

    <title><?= $title; ?></title>

    <!-- Style -->
    <?php if (isset($style)): ?>
        <?php foreach ($style as $val): ?>
            <link href="<?= $val; ?>" rel="stylesheet" />
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- favicon -->
    <?php if (isset($icon)): ?>
        <?php foreach ($icon as $val): ?>
            <link href="<?= $val; ?>" rel="icon" />
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- Theme -->
    <meta name="theme-color" content="#712cf9" />
    <link rel="manifest" href="/assets/manifest.json" />
</head>

<body class="<?= $body['className'] ?? '' ?>" id="<?= $body['id'] ?? ''; ?>">