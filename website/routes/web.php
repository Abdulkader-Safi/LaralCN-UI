<?php

use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::get("/", [DocsController::class, "index"])->name("docs.index");
Route::get("/theming", [DocsController::class, "theming"])->name(
    "docs.theming",
);
Route::get("/plain-blade", [DocsController::class, "plainBlade"])->name(
    "docs.plain-blade",
);
Route::get("/components/{name}", [DocsController::class, "show"])->name(
    "docs.show",
);
