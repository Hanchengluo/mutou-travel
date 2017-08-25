<?php
namespace App\Listeners\Auth;

use Laravel\Passport\Events\RefreshTokenCreated;
use Illuminate\Support\Facades\DB;

class PruneOldTokens
{
    /**
     * Handle the event.
     *
     * @param  RefreshTokenCreated  $event
     * @return void
     */
    public function handle(RefreshTokenCreated $event)
    {
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', '!=', $event->accessTokenId)
            ->where('revoked', true)->delete();
    }
}