<?php
Route::middleware(['jwt.auth'])->group(function () {
    \Nuwave\Lighthouse\Support\Http\Controllers\GraphQLController::routes();
});
