<?php

namespace App\Console\Commands;

use App\Components\ImportDataClient;
use App\Models\Post;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use JsonException;

class ImportJsonPlaceholderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:json-placeholder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = ' Get data from JsonPlaceholder';

    /**
     * Execute the console command.
     * @throws JsonException|GuzzleException
     */
    public function handle()
    {
        $import = new ImportDataClient();
        $response = $import->client->request('GET', 'posts');
        $posts = json_decode(
            $response->getBody()->getContents(),
            false,
            512,
            JSON_THROW_ON_ERROR
        );

        foreach ($posts as $post) {
            Post::firstOrCreate(
                [
                    'title' => $post->title
                ], [
                    'title' => $post->title,
                    'content' => $post->body,
                    'category_id' => 3
            ]);
        }

        dd('Proccess is finished');
    }
}
