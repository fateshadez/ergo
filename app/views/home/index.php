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
  <link rel="stylesheet" href="/css/app.css">
  <script src="https://kit.fontawesome.com/7efba6ae0b.js" crossorigin="anonymous"></script>
  <link rel="icon" type="image/x-icon" href="/leaf-icon.svg">
  <title>Task App</title>
</head>

<body class="font-inter transition duration-300 ease h-full bg-white dark:bg-slate-950 overflow-hidden">

  <script src="/js/color-theme.js" defer></script>
  <script src="/js/tasks.js" defer></script>

  <!-- Sidebar -->
  <div class="flex bg-gray-100 dark:bg-slate-950 overflow-hidden h-screen">
    <div
      class="hidden md:flex md:w-4/12 lg:w-3/12 flex-col bg-white dark:bg-slate-900 shadow-lg p-3 pt-0 pl-0 pr-0 gap-2 dark:border-gray-800 dark:border-r">

      <h2 id="app-name"
        class="text-xl py-4 px-4 md:text-2xl font-bold border-b shadow-[0px_4px_6px_-2px_rgba(0,0,0,0.1)] border-gray-200 dark:border-gray-800 dark:text-white">
        Ergo</h2>

      <!-- Buttons -->
      <?php $colors = ['All' => 'bg-gray-800', 'Today' => 'bg-blue-800', 'Scheduled' => 'bg-orange-800', 'Completed' => 'bg-green-800', 'Overdue' => "bg-red-800"];
      foreach ($colors as $key => $value) { ?>
        <div data-filter="<?= strtolower($key) ?>"
          class="select-none justify-center cursor-pointer relative inline-flex items-center <?= $value ?> text-white px-6 py-4 transition-all duration-500 ease right-8 hover:right-1 [clip-path:polygon(0%_0%,95%_0%,100%_50%,95%_100%,0%_100%)]">
          <?= $key ?>
        </div>
      <?php } ?>

      <div data-modal="create-task"
        class="p-[2px] mt-auto mb-9 w-full cursor-pointer relative bg-gray-500 transition-all duration-500 ease right-8 hover:right-1 [clip-path:polygon(0%_0%,95%_0%,100%_50%,95%_100%,0%_100%)]">
        <div data-modal="create-task"
          class="select-none w-full justify-center cursor-pointer relative flex items-center bg-white dark:bg-slate-900 text-black dark:text-white px-6 py-4 transition-[right] duration-500 ease [clip-path:polygon(0%_0%,95%_0%,100%_50%,95%_100%,0%_100%)]">
          Create task
        </div>
      </div>
    </div>
    <div class="flex flex-col flex-1 justify-between">

      <!-- Mobile sidebar drawer -->
      <div id="mobile-menu" class="hidden fixed inset-0 z-50 md:hidden">
        <div id="menu-backdrop" class="absolute inset-0 bg-black opacity-50"></div>
        <div class="absolute left-0 top-0 h-full w-64 bg-white dark:bg-slate-900 shadow-lg p-4 pl-0 z-10">
          <div class="flex w-full justify-between items-center mb-4 pb-4 border-b dark:border-gray-800 border-gray-200">
            <h1 class="text-2xl font-bold dark:text-white pl-4">Ergo</h1>
            <button id="menu-close" class="text-2xl cursor-pointer dark:text-white">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
          <div class="flex flex-col gap-2">
            <?php
            foreach ($colors as $key => $value) { ?>
              <div data-filter="<?= strtolower($key) ?>"
                class="justify-center cursor-pointer relative inline-flex items-center <?= $value ?> text-white px-6 py-4 transition-all duration-500 ease right-3 hover:right-0 [clip-path:polygon(0%_0%,95%_0%,100%_50%,95%_100%,0%_100%)]"
                data-id="<?= $task['id'] ?>" data-due-date="<?= $task['due_date'] ?>"
                data-status="<?= $task['status'] ?>">
                <?= $key ?>
              </div>
            <?php } ?>
            <div data-modal="create-task"
              class="p-[2px] mt-auto w-full cursor-pointer relative bg-gray-500 transition-all duration-500 right-3 ease [clip-path:polygon(0%_0%,95%_0%,100%_50%,95%_100%,0%_100%)]">
              <div data-modal="create-task"
                class="select-none w-full justify-center cursor-pointer relative flex items-center bg-white dark:bg-slate-900 text-black dark:text-white px-6 py-4 transition-all duration-500 ease [clip-path:polygon(0%_0%,95%_0%,100%_50%,95%_100%,0%_100%)]">
                Create task
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <!-- Header -->
      <div
        class="flex w-full bg-white dark:bg-slate-900 justify-between items-center px-4 py-4 relative z-10 shadow-[0px_4px_6px_-2px_rgba(0,0,0,0.1)] dark:border-b border-gray-200 dark:border-gray-800">
        <button id="menu-toggle" class="md:hidden text-2xl cursor-pointer bg-transparent dark:text-white">
          <i class="fa-solid fa-bars"></i>
        </button>
        <h2 class="text-xl md:text-2xl font-bold dark:text-white">Your tasks</h2>
        <button id="dark-mode"
          class="cursor-pointer text-2xl bg-transparent hover:transition duration-300 ease-in-out hover:rotate-180 hover:scale-120 overflow-hidden">
          <i class="fa-solid fa-moon dark:text-white"></i>
          <i class="fa-solid fa-sun text-amber-400"></i>
        </button>
      </div>

      <div class="flex-1 p-4 text-gray-500 dark:text-gray-400 overflow-y-auto">
        <div class="flex flex-col gap-3">

          <?php if (empty($tasks)): ?>
            <p class="text-gray-400 text-center mt-8">No tasks yet. Create one!</p>
          <?php else: ?>
          <!-- Bulk actions -->
            <div class="flex items-center py-2">
              <div id="bulk-actions" class="hidden flex-wrap items-center gap-2">
                <button id="delete-selected"
                  class="h-8 px-3 leading-none text-sm bg-red-600 hover:bg-red-500 text-white font-semibold">
                  Delete selected
                </button>
                <button id="complete-selected"
                  class="h-8 px-3 text-sm leading-none bg-green-600 hover:bg-green-500 text-white font-semibold">
                  Mark as completed
                </button>
                <button id="edit-selected" style="display:none"
                  class="h-8 px-3 text-sm leading-none bg-blue-600 hover:bg-blue-500 text-white font-semibold">
                  Edit
                </button>
                <span id="selected-count" class="h-8 flex items-center text-sm leading-none text-gray-500 dark:text-gray-400"></span>
                <label
                  class="h-8 flex items-center leading-none gap-2 cursor-pointer select-none text-sm text-gray-700 dark:text-gray-300">
                  <input type="checkbox" id="select-all" class="w-4 h-4 cursor-pointer accent-blue-600">
                  Select all
                </label>
              </div>

              <!-- Sorting button -->
              <button id="sort-toggle"
                class="flex items-center gap-2 select-none self-start ml-auto px-2.5 sm:px-3 py-2 sm:py-1.5 sm:text-sm bg-gray-600 hover:bg-gray-500 text-white font-semibold">
                <span class="hidden sm:inline">Sort by priority</span>
                <i class="fa-solid fa-arrow-down"></i>
              </button>
            </div>

            <?php foreach ($tasks as $task): ?>
              <div
                class="task-tile select-none items-stretch flex gap-3 bg-white dark:bg-slate-900 p-4 shadow-sm border border-gray-200 dark:border-slate-800"
                data-id="<?= $task['id'] ?>" data-due-date="<?= $task['due_date'] ?>" data-status="<?= $task['status'] ?>"
                data-priority="<?= $task['priority'] ?>">

                <!-- Checkmark -->
                <div class="flex items-center border-r-2 border-gray-300 dark:border-slate-800 pr-4 py-auto">
                  <input type="checkbox" class="task-checkbox mt-1 w-4 h-4 cursor-pointer accent-blue-600"
                    data-id="<?= $task['id'] ?>">
                </div>

                <!-- Task content -->
                <div class="flex flex-1 gap-1 justify-between">

                  <div class="flex flex-col gap-1">
                    <h3 class="font-semibold text-gray-800 dark:text-white">
                      <?= htmlspecialchars($task['title']) ?>
                    </h3>
                    <?php if (!empty($task['desc'])): ?>
                      <p class="text-sm text-gray-500 dark:text-gray-400"><?= htmlspecialchars($task['desc']) ?></p>
                    <?php endif; ?>
                    <div class="flex gap-4 mt-1 text-xs text-gray-400 dark:text-gray-500">
                      <span><i class="fa-solid fa-calendar-plus mr-1 text-blue-600"></i><?= Helper::toLocalTime($task['created_at']) ?></span>
                      <?php if (!empty($task['due_date'])): ?>
                        <?php if ($task['status'] === 'OVERDUE'): ?>
                          <span><i class="fa-solid fa-calendar-xmark mr-1 text-red-900"></i><?= Helper::toLocalTime($task['due_date']) ?></span>
                        <?php elseif ($task['status'] === 'PENDING'): ?>
                          <span><i class="fa-solid fa-clock mr-1 text-orange-600"></i><?= Helper::toLocalTime($task['due_date']) ?></span>
                        <?php else: ?>
                          <span><i class="fa-solid fa-calendar-check mr-1 text-green-900"></i><?= Helper::toLocalTime($task['due_date']) ?></span>
                        <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="flex flex-col items-end justify-between">
                    <span class="text-xs px-2 py-0.5 font-semibold
      <?= $task['priority'] === 'HIGH' ? 'bg-red-100 text-red-600' : '' ?>
      <?= $task['priority'] === 'MEDIUM' ? 'bg-yellow-100 text-yellow-600' : '' ?>
      <?= $task['priority'] === 'LOW' ? 'bg-green-100 text-green-600' : '' ?>">
                      <?= $task['priority'] ?>
                    </span>
                    <span class="text-xs px-2 py-0.5 font-semibold
      <?= $task['status'] === 'COMPLETED' ? 'bg-green-100 text-green-600' : '' ?>
      <?= $task['status'] === 'PENDING' ? 'bg-yellow-100 text-yellow-600' : '' ?>
      <?= $task['status'] === 'OVERDUE' ? 'bg-red-100 text-red-600' : '' ?>">
                      <?= $task['status'] ?>
                    </span>
                  </div>

                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

        </div>
      </div>

      <div
        class="flex w-full bg-white dark:bg-slate-900 justify-end px-4 py-3 border-t border-gray-200 dark:border-gray-800">
        <a href="/auth/logout"
          class="px-6 py-3 text-lg bg-blue-600 font-semibold text-white shadow-sm hover:bg-blue-500">
          Logout
        </a>
      </div>

    </div>
  </div>

  <!-- Create Task Modal -->
  <div id="create-task-modal" class="hidden fixed inset-0 z-50">
    <div id="modal-backdrop" class="absolute inset-0 bg-black opacity-50"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4">
      <div class="bg-white dark:bg-slate-900 w-full max-w-md p-6 shadow-xl z-10">
        <div class="flex justify-between items-center mb-4">
          <h3 id="modal-title" class="text-xl font-bold dark:text-white">Create Task</h3>
          <button id="modal-close" class="text-2xl cursor-pointer dark:text-white">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <form id="create-task-form" action="/tasks/create" method="post" class="flex flex-col gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input type="text" name="title"
              class="mt-1 block w-full border border-gray-300 dark:border-slate-700 px-3 py-2 dark:bg-slate-800 dark:text-white"
              placeholder="Task title" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea name="desc" rows="3"
              class="mt-1 block w-full border border-gray-300 dark:border-slate-700 px-3 py-2 dark:bg-slate-800 dark:text-white"
              placeholder="Task description"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Priority</label>
            <select name="priority"
              class="mt-1 block w-full border border-gray-300 dark:border-slate-700 px-3 py-2 dark:bg-slate-800 dark:text-white">
              <option value="LOW">Low</option>
              <option value="MEDIUM">Medium</option>
              <option value="HIGH">High</option>
            </select>
          </div>
          <div>
            <div class="flex gap-2">
              <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due date</label>
                <input type="date" name="due_date"
                  class="mt-1 block w-full border border-gray-300 dark:border-slate-700 px-3 py-2 dark:bg-slate-800 dark:text-white">
              </div>
              <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Due time</label>
                <input type="time" name="due_time"
                  class="mt-1 block w-full border border-gray-300 dark:border-slate-700 px-3 py-2 dark:bg-slate-800 dark:text-white">
              </div>
            </div>
          </div>
          <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2">
            Create
          </button>
        </form>
      </div>
    </div>
  </div>

</body>

</html>
