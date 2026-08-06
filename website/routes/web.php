<?php

use App\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::get("/", [DocsController::class, "home"])->name("home");

// Markdown channel. These come before the HTML routes they shadow, otherwise
// `/components/{name}` swallows `button.md` as a component name.
Route::get("/llms.txt", [DocsController::class, "llms"])->name("llms");
Route::get("/llms-full.txt", [DocsController::class, "llmsFull"])->name(
    "llms.full",
);
Route::get("/components.md", [DocsController::class, "indexMarkdown"])->name(
    "docs.index.md",
);
Route::get("/components/{name}.md", [
    DocsController::class,
    "showMarkdown",
])->name("docs.show.md");
Route::get("/blocks.md", [DocsController::class, "blocksIndexMarkdown"])->name(
    "blocks.index.md",
);
Route::get("/blocks/{slug}.md", [
    DocsController::class,
    "blockShowMarkdown",
])->name("blocks.show.md");
Route::get("/theming.md", [DocsController::class, "themingMarkdown"])->name(
    "docs.theming.md",
);

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
Route::get("/blocks", [DocsController::class, "blocksIndex"])->name(
    "blocks.index",
);
Route::get("/blocks/{slug}/preview", [
    DocsController::class,
    "blockPreview",
])->name("blocks.preview");
Route::get("/blocks/{slug}", [DocsController::class, "blockShow"])->name(
    "blocks.show",
);
Route::get("/components/{name}", [DocsController::class, "show"])->name(
    "docs.show",
);
