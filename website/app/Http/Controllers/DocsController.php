<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\Registry;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DocsController extends Controller
{
    public function __construct(private readonly Registry $registry) {}

    public function home(): View
    {
        $showcase = ['button', 'card', 'badge'];

        return view('landing', [
            'categories' => $this->registry->byCategory(),
            'total' => $this->registry->all()->count(),
            'showcase' => $this->registry
                ->all()
                ->whereIn('name', $showcase)
                ->sortBy(fn (array $c) => array_search($c['name'], $showcase, true))
                ->values(),
        ]);
    }

    public function index(): View
    {
        return view('docs.index', [
            'categories' => $this->registry->byCategory(),
            'total' => $this->registry->all()->count(),
        ]);
    }

    public function show(string $name): View
    {
        $entry = $this->registry->find($name);

        if ($entry === null) {
            throw new NotFoundHttpException("Unknown component [{$name}].");
        }

        $source = $this->registry->source($name, $entry['files'][0]['source']);
        $hasPreview = view()->exists("previews.{$name}");

        return view('docs.show', [
            'entry' => $entry,
            'source' => $source,
            'command' => $this->registry->command($name),
            'hasPreview' => $hasPreview,
            'all' => $this->registry->byCategory(),
        ]);
    }

    public function gettingStarted(): View
    {
        $entry = $this->registry->find('button');

        return view('docs.getting-started', [
            'all' => $this->registry->byCategory(),
            'entry' => $entry,
            'source' => $entry === null
                ? ''
                : $this->registry->source('button', $entry['files'][0]['source']),
            'command' => $this->registry->command('button'),
            'hasPreview' => view()->exists('previews.button'),
        ]);
    }

    public function theming(): View
    {
        return view('docs.theming', [
            'theme' => $this->registry->themeCss(),
            'all' => $this->registry->byCategory(),
        ]);
    }

    public function plainBlade(): View
    {
        return view('docs.plain-blade', [
            'all' => $this->registry->byCategory(),
        ]);
    }
}
