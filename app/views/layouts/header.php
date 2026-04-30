<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? 'Pet Clinic — caring for your furry family.'); ?>">
    <title><?php echo htmlspecialchars($pageTitle ?? 'Pet Clinic'); ?></title>

    <!-- Google Fonts: Nunito -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Global stylesheet — the ONLY CSS file for the whole system -->
    <link rel="stylesheet" href="css/style.css">

    <?php if (!empty($extraHead)) echo $extraHead; ?>
</head>
<body class="<?php echo htmlspecialchars($bodyClass ?? ''); ?>">
