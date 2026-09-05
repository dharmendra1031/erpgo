<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'XSS'])->group(function () {
    Route::get('/search', 'HardeningLegacyController@search')->name('search.json');
    Route::get('users-view', 'HardeningLegacyController@filterUserView')->name('filter.user.view');
    Route::get('checkuserexists', 'HardeningLegacyController@checkUserExists')->name('user.exists');
    Route::get('/expense-list', 'HardeningLegacyController@expenseList')->name('expense.list');
    Route::get('timesheet-view', 'TimesheetController@filterTimesheetTableView')->name('filter.timesheet.view');
    Route::get('/{uid}/notification/seen', 'HardeningLegacyController@notificationSeen')
        ->where('uid', '[A-Za-z0-9\-]+')
        ->name('notification.seen');
});
