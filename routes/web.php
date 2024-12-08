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

Route::middleware(['auth'])->group(function () {

    // Admin routes
    Route::middleware(['admin', '2fa'])->group(function () {
        Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::post('/accounts/open-multiple', [AdminController::class, 'openMultipleAccounts'])->name('admin.accounts.openMultiple');
        
        // Manage Users Route
        Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');

        // Manage Accounts Route
        Route::get('/admin/accounts', [AccountController::class, 'index'])->name('admin.accounts');
        Route::get('/admin/accounts/create', [AccountController::class, 'create'])->name('admin.accounts.create');
        Route::post('/admin/accounts/store', [AccountController::class, 'store'])->name('admin.accounts.store');
        Route::get('/admin/accounts/showTransactions/{accountId}', [AccountController::class, 'showTransactions'])->name('admin.accounts.showTransactions');
        
        // // Transactions
        // Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions');
        // Route::post('/admin/transactions/transfer', [TransactionController::class, 'transfer'])->name('admin.transactions.transfer');
        
        // Route to display the form to open multiple accounts
        Route::get('/admin/open-multiple-accounts', [AccountController::class, 'openMultipleAccountsForm'])->name('admin.accounts.openMultipleForm');

        // Route to handle the form submission for opening multiple accounts
        Route::post('/admin/open-multiple-accounts', [AccountController::class, 'openMultipleAccounts'])->name('admin.accounts.openMultiple');
    });

    // User routes
    Route::middleware(['2fa'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/home', [HomeController::class, 'index']);

        // Route to handle the user funds
        Route::get('/history', [FundTransferController::class, 'history'])->name('history.index');
        Route::get('/transfer', [FundTransferController::class, 'index'])->name('transfer.index');
        Route::post('/transfer', [FundTransferController::class, 'store'])->name('transfer.store');
    });

    // Currency Conversion
    Route::get('/currency-convert/{amount}/{from}/{to}', [CurrencyConversionController::class, 'convert'])->name('currency.convert');
});

// Two-Factor Authentication routes
Route::middleware('auth')->group(function () {
    Route::get('/enable-two-factor', [TwoFactorController::class, 'enableTwoFactor'])->name('two-factor.enable');
    Route::post('/verify-two-factor', [TwoFactorController::class, 'verifyTwoFactor'])->name('two-factor-verify');
});
