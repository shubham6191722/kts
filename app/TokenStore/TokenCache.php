<?php

namespace App\TokenStore;

use App\Models\Token;

class TokenCache {

    public function storeTokens($accessToken, $user,$oauthId) {

        $get_getToken = $accessToken->getToken();
        $get_getExpires = $accessToken->getExpires();
        $get_getRefreshToken = $accessToken->getRefreshToken();
        $get_getValues = $accessToken->getValues();


        $userName = $user->getDisplayName();
        $userEmail = $user->getMail() ? $user->getMail() : $user->getUserPrincipalName();
        $userTimeZone = $user->getMailboxSettings()->getTimeZone();

        $check_token = Token::where('user_id','=',$oauthId)->first();
        if(isset($check_token) && !empty($check_token)){
            $token = Token::find($check_token->id);
        }else{
            $token = new Token;    
        }
        
        $token->accessToken = $get_getToken;
        $token->expires = $get_getExpires;
        $token->refreshToken = $get_getRefreshToken;
        $token->values_token_type = $get_getValues['token_type'];
        $token->values_scope = $get_getValues['scope'];
        $token->values_ext_expires_in = $get_getValues['ext_expires_in'];
        $token->values_id_token = $get_getValues['id_token'];
        $token->user_id = $oauthId;

        if(isset($userName) && !empty($userName)){
            $token->userName = $userName;
        }
        if(isset($userEmail) && !empty($userEmail)){
            $token->userEmail = $userEmail;
        }
        if(isset($userTimeZone) && !empty($userTimeZone)){
            $token->userTimeZone = $userTimeZone;
        }else{
            $token->userTimeZone = 'GMT Standard Time';
        }
        $token->save();

        // session([
        //     'accessToken' => $accessToken->getToken(),
        //     'refreshToken' => $accessToken->getRefreshToken(),
        //     'tokenExpires' => $accessToken->getExpires(),
        //     'userName' => $user->getDisplayName(),
        //     'userEmail' => null !== $user->getMail() ? $user->getMail() : $user->getUserPrincipalName(),
        //     'userTimeZone' => $user->getMailboxSettings()->getTimeZone()
        // ]);
    }

    // public function clearTokens() {
    //     session()->forget('accessToken');
    //     session()->forget('refreshToken');
    //     session()->forget('tokenExpires');
    //     session()->forget('userName');
    //     session()->forget('userEmail');
    //     session()->forget('userTimeZone');
    // }

    // <GetAccessTokenSnippet>
    public function getAccessToken($user_id) {

        $accessToken = null;
        $token = Token::where('user_id','=',$user_id)->first();

        if(isset($token) && !empty($token)){
            
            $accessToken = $token->accessToken;
            $refreshToken = $token->refreshToken;
            $tokenExpires = $token->expires;
            // Check if tokens exist
            if (empty($accessToken) || empty($refreshToken) || empty($tokenExpires)) {
                return '';
            }
    
            // Check if token is expired
            //Get current time + 5 minutes (to allow for time differences)
            $now = time() + 300;
            if ($tokenExpires <= $now) {
                // Token is expired (or very close to it)
                // so let's refresh
    
                // Initialize the OAuth client
                $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                    'clientId'                => config('azure.appId'),
                    'clientSecret'            => config('azure.appSecret'),
                    'redirectUri'             => config('azure.redirectUri'),
                    'urlAuthorize'            => config('azure.authority').config('azure.authorizeEndpoint'),
                    'urlAccessToken'          => config('azure.authority').config('azure.tokenEndpoint'),
                    'urlResourceOwnerDetails' => '',
                    'scopes'                  => config('azure.scopes')
                ]);
    
                try {
                    $newToken = $oauthClient->getAccessToken('refresh_token', [
                        'refresh_token' => $refreshToken
                    ]);
    
                    // Store the new values
                    $this->updateTokens($newToken,$user_id);
    
                    return $newToken->getToken();
                }
                catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                    return '';
                }
            }
        }
        
        // Token is still valid, just return it
        return $accessToken;
        // return session('accessToken');
    }
    // </GetAccessTokenSnippet>

    // <UpdateTokensSnippet>
    public function updateTokens($accessToken,$user_id) {
      
        $get_getToken = $accessToken->getToken();
        $get_getExpires = $accessToken->getExpires();
        $get_getRefreshToken = $accessToken->getRefreshToken();
        // $get_getValues = $accessToken->getValues();

        $check_token = Token::where('user_id','=',$user_id)->first();
        if(isset($check_token) && !empty($check_token)){
            $token = Token::find($check_token->id);

            $token->accessToken = $get_getToken;
            $token->expires = $get_getExpires;
            $token->refreshToken = $get_getRefreshToken;
            $token->save();
        }
    }
    // </UpdateTokensSnippet>
}