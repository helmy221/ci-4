<?= $this->extend('layouts/layout_full') ?>

<?= $this->section('content') ?>
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Sign In</h1>
        <p class="text-gray-500 dark:text-gray-400">Enter your email and password to sign in</p>
    </div>

    <form action="<?= base_url('doLogin') ?>" method="post" class="space-y-5">
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="text" name="identifier" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="you@example.com" required>
        </div>
        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="********" required>
            <span
                class="absolute z-30 text-gray-500 -translate-y-1/2 cursor-pointer right-4 top-1/2 dark:text-gray-400">
            </span>
        </div>
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center">
                <input type="checkbox" class="mr-2"> Remember me
            </label>
            <!-- <a href="#" class="text-blue-500 hover:underline">Forgot password?</a> -->
        </div>
        <button type="submit" class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Sign In</button>
    </form>

    <!-- <p class="mt-5 text-sm text-center text-gray-600 dark:text-gray-400">
        Don't have an account?
        <a href="<?= base_url('auth/register') ?>" class="text-blue-500 hover:underline">Sign Up</a>
    </p> -->
</div>


<?= $this->endSection() ?>