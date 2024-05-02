<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class live extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:live';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if ConkDetects is live on TikTok and send a Discord alert if they are.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $httpClient = new \GuzzleHttp\Client();
        $response = $httpClient->get('https://www.tiktok.com/@conkdetects/live');
        $htmlString = (string) $response->getBody();
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($htmlString);
        $xpath = new \DOMXPath($doc);

        $full_json = $xpath->evaluate("//script[@id=\"SIGI_STATE\"]");
        $parsed = json_decode($full_json[0]->nodeValue, true);
        $user_count = $parsed['LiveRoom']['liveRoomUserInfo']['liveRoom']['liveRoomStats']['userCount'];

        if ($user_count > 10) {
            DiscordAlert::message("ConkDetects is live with {$user_count} viewers", [
                [
                    'title' => '@ConkDetects is live, YEAH!',
                    'description' => 'https://www.tiktok.com/@conkdetects/live',
                    'color' => '#50C878',
                ]
            ]);
        }
    }
}
