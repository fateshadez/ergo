<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/task-app/public/css/app.css">
    <script src="https://kit.fontawesome.com/7efba6ae0b.js" crossorigin="anonymous"></script>
    <title><?= $title ?? 'Task App' ?></title>
</head>
<body class="h-full bg-white dark:bg-slate-950">
    <script src="/task-app/public/js/main.js" defer></script>
    <?= $content ?>
</body>
</html>