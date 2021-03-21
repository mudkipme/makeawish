<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Source;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a home controller.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * Project Homepage
     *
     * @param  string $locale
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function show($locale = "")
    {
        if (! empty($locale)) {
            if (! in_array($locale, array_keys(Config::get('app.available_locales')))) {
                abort(404);
            }
        }

        return inertia('home', [
            'letter' => $this->getText('letter'),
            'announcement' => $this->getText('announcement'),
            'posts' => $this->posts(),
            'signNumber' => intval(Source::sum('post_number')),
            'campaignEnded' => boolval(Config::get('app.campaign_ended')),
            'portfolio' => $this->portfolio(),
        ]);
    }

    /**
     * Read the markdown text
     *
     * @param  string $filename
     * @return string
     */
    private function getText($filename)
    {
        $locale = App::getLocale();
        $contentFolder = Config::get('app.content_folder');
        $filename = base_path("{$contentFolder}/{$locale}/{$filename}.md");

        if ($this->files->exists($filename)) {
            return $this->files->get($filename);
        }
        return '';
    }

    private function posts()
    {
        return Post::where('public', 1)->where('patrolled', 1)->inRandomOrder()->take(30)->get();
    }

    private function portfolio()
    {
        $contentFolder = Config::get('app.content_folder');
        $filename = base_path("{$contentFolder}/portfolio.json");

        if ($this->files->exists($filename)) {
            $list = json_decode($this->files->get($filename), true);
            shuffle($list);
            $list = array_slice($list, 0, 15);
            return $list;
        }
        return [];
    }
}
