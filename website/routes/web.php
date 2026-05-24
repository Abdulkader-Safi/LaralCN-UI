<?php

use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::get("/", [DocsController::class, "home"])->name("home");
Route::get("/components", [DocsController::class, "index"])->name("docs.index");
Route::get("/getting-started", [DocsController::class, "gettingStarted"])->name(
    "docs.getting-started",
);
Route::get("/theming", [DocsController::class, "theming"])->name(
    "docs.theming",
);
Route::get("/plain-blade", [DocsController::class, "plainBlade"])->name(
    "docs.plain-blade",
);
Route::get("/blocks", [DocsController::class, "blocks"])->name("blocks.index");
Route::view("/blocks/sidebar-08", "blocks.sidebar-08")->name(
    "blocks.sidebar-08",
);
Route::get("/components/{name}", [DocsController::class, "show"])->name(
    "docs.show",
);
