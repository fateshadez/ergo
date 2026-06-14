<!DOCTYPE html>

<html class="h-full" lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/app.css">
  <script src="https://kit.fontawesome.com/7efba6ae0b.js" crossorigin="anonymous"></script>
  <title>Sign In</title>
</head>

<body class="font-inter h-full bg-white dark:bg-slate-950">

  <script src="/js/main.js" defer></script>
  <script src="/js/color-theme.js" defer></script>

  <button id="dark-mode"
    class="fixed top-3.5 right-5 cursor-pointer text-2xl bg-transparent hover:transition duration-300 ease-in-out hover:rotate-180 hover:scale-120">
    <i class="fa-solid fa-moon"></i>
    <i class="fa-solid fa-sun text-amber-400"></i>
  </button>

  <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:full sm:max-w-sm">
      <h1
        class="transition duration-300 ease text-center text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl md:text-6xl">
        Ergo
      </h1>
      <h2
        class="transition duration-300 ease mt-6 text-center text-2xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-2xl md:text-3xl lg:text-3xl">
        Keep everything in check
      </h2>
      <h2 class="transition duration-300 ease mt-2 text-center text-md text-gray-900 dark:text-white font-semibold">
        Start managing your tasks today
      </h2>
      <h3
        class="transition duration-300 ease mt-8 text-center text-2xl md:text-3xl text-gray-900 dark:text-white font-bold">
        Sign in</h3>
    </div>
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
      <form id="form" name="sign-in-form" action="/auth/login" method="post" class="space-y-6">
        <div>
          <label for="email" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Email:</label>
          <div class="mt-2">
            <input name="email" type="email" id="email" placeholder="Email Address"
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-blue-500" />
          </div>
        </div>

        <div class="email-error-log !mt-2">
          <?php if (isset($errors['missing_email'])): ?>
            <p class="text-red-500 text-sm"><?= $errors['missing_email'] ?></p>
          <?php endif; ?>
        </div>

        <div>
          <label for="password" class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100">Password:</label>
          <div class="mt-2">
            <input name="password" type="password" id="password" placeholder="Your password"
              class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:placeholder:text-gray-500 dark:focus:outline-blue-500">
          </div>
        </div>

        <div class="password-error-log !mt-2">
          <?php if (isset($errors['missing_password'])): ?>
            <p class="text-red-500 text-sm mt-1">
              <?= $errors['missing_password'] ?>
            </p>
          <?php endif; ?>

          <?php if (!isset($errors['missing_password']) && isset($errors['invalid_password_len'])): ?>
            <p class="text-red-500 text-sm mt-1">
              <?= $errors['invalid_password_len'] ?>
            </p>
          <?php endif; ?>
        </div>

        <div>
          <button type="submit" id="submit-button"
            class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 dark:bg-blue-500 dark:shadow-none dark:hover:bg-blue-400 dark:focus-visible:outline-blue-500">
            Sign In
          </button>
        </div>

        <?php if (isset($errors['not_registered'])): ?>
          <p class="text-red-500 text-sm !mt-2 text-center"><?= $errors['not_registered'] ?></p>
        <?php endif; ?>
      </form>

      <p class="mt-10 text-center text-sm/6 text-gray-500 dark:text-gray-400">Don't have an account?
        <a href="/auth/register"
          class="font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">Sign
          Up.</a>
      </p>
    </div>
  </div>
</body>

</html>