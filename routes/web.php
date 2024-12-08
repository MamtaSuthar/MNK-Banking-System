<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FundTransferController;
use App\Http\Controllers\CurrencyConversionController;
use App\Http\Controllers\TransactionController;

Auth::routes(['verify' => true]);

Route::middleware(['auth', \App\Http\Middleware\TwoFactorAuth::class,\App\Http\Middleware\EnsureUserRole::class])->group(function () {

    // User routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [HomeController::class, 'index']);

    // Route to handle the user funds
    Route::get('/history', [FundTransferController::class, 'history'])->name('history.index');
    Route::get('/currency', [FundTransferController::class, 'currency'])->name('currency.index');
    Route::post('/currency', [FundTransferController::class, 'currency_store'])->name('currency.store');
    Route::get('/transfer', [FundTransferController::class, 'index'])->name('transfer.index');
    Route::post('/transfer', [FundTransferController::class, 'store'])->name('transfer.store');

    // Currency Conversion
    Route::get('/currency-convert/{amount}/{from}/{to}', [CurrencyConversionController::class, 'convert'])->name('currency.convert');
});

Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Manage Users Route
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');

    // Manage Accounts Route
    Route::get('/admin/accounts', [AccountController::class, 'index'])->name('admin.accounts');
    Route::get('/admin/accounts/create', [AccountController::class, 'create'])->name('admin.accounts.create');
    Route::post('/admin/accounts/store', [AccountController::class, 'store'])->name('admin.accounts.store');
    Route::get('/admin/accounts/showTransactions/{accountId}', [AccountController::class, 'showTransactions'])->name('admin.accounts.showTransactions');
    
    // // Transactions
    Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions');
    Route::post('/admin/transactions/transfer', [TransactionController::class, 'transfer'])->name('admin.transactions.transfer');
    
    // Route to display the form to open multiple accounts
    Route::get('/admin/open-multiple-accounts', [AccountController::class, 'openMultipleAccountsForm'])->name('admin.accounts.openMultipleForm');

    // Route to handle the form submission for opening multiple accounts
    Route::post('/accounts/open-multiple', [AdminController::class, 'openMultipleAccounts'])->name('admin.accounts.openMultiple');
});

   // Two-Factor Authentication routes
   Route::get('/enable-two-factor', [TwoFactorController::class, 'enable2FA'])->name('two-factor.enable');
   Route::post('/verify-two-factor', [TwoFactorController::class, 'verify2FA'])->name('two-factor-verify');


