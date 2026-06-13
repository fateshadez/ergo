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
    <div class="flex flex-wrap bg-gray-100 w-full h-screen">
        <div class="w-3/12 bg-white dark:bg-slate-900 rounded p-3 shadow-lg">
            <!-- sidebar -->
        </div>
        <div class="w-9/12 flex flex-col justify-between">
            <div class="flex w-full bg-white dark:bg-slate-900 justify-end px-4 py-2">
                <!-- header -->
                <?= $header ?? '' ?>
            </div>
            <div class="flex-1 p-4">
                <?= $content ?>
            </div>
            <footer class="flex w-full bg-white dark:bg-slate-900 justify-end px-4 py-2 border-t border-gray-200 dark:border-slate-800">
                <a href="/task-app/auth/logout"
                    class="px-3 py-1.5 text-sm rounded-md bg-blue-600 font-semibold text-white shadow-sm hover:bg-blue-500">
                    Logout
                </a>
            </footer>
        </div>
    </div>
</body>
</html>