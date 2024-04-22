<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/14/2024
 * @time: 11:51 AM
 */

Route::middleware('verified')->get('/user', function (Request $request) {
    return $request->user();
});
