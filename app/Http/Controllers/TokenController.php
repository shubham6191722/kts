<?php
// Copyright (c) Microsoft Corporation.
// Licensed under the MIT License.

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\TokenStore\TokenCache;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\Models\Token;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use session;

class TokenController extends Controller
{
    public function signin()
    {
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

        $authUrl = $oauthClient->getAuthorizationUrl();
        // Save client state so we can validate in callback
        session(['oauthState' => $oauthClient->getState()]);
        session(['oauthId' => Auth::user()->id]);

        // Redirect to AAD signin page
        return redirect()->away($authUrl);
    }

    public function callback(Request $request)
    {
        $expectedState = session('oauthState');
        $oauthId = session('oauthId');
        $request->session()->forget('oauthState');
        $request->session()->forget('oauthId');
        $providedState = $request->query('state');

        $user_get_data = User::find($oauthId);

        if($user_get_data->role == 1){
            $role_name = 'rats-5768.showSetting';
        }elseif($user_get_data->role == 2){
            $role_name = 'client.showSetting';
        }elseif($user_get_data->role == 3){
            $role_name = 'staff.showSetting';
        }elseif($user_get_data->role == 4){
            $role_name = 'recruiter';
        }elseif($user_get_data->role == 5){
            $role_name = 'candidate.profileSetting';
        }

        if (!isset($expectedState)) {
            return redirect()->route($role_name);
            // return redirect('/');
        }

        if (!isset($providedState) || $expectedState != $providedState) {
            return redirect()->route($role_name)->with('error', 'Invalid auth state')->with('errorDetail', 'The provided auth state did not match the expected value');
            // return redirect('/')->with('error', 'Invalid auth state')->with('errorDetail', 'The provided auth state did not match the expected value');
        }

        $authCode = $request->query('code');
        if (isset($authCode)) {
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
                // Make the token request
                $accessToken = $oauthClient->getAccessToken('authorization_code', ['code' => $authCode]);

                $graph = new Graph();
                $graph->setAccessToken($accessToken->getToken());

                $user = $graph->createRequest('GET', '/me?$select=displayName,mail,mailboxSettings,userPrincipalName')->setReturnType(Model\User::class)->execute();

                $tokenCache = new TokenCache();
                $tokenCache->storeTokens($accessToken, $user,$oauthId);

                return redirect()->route($role_name)->with('success', 'Outlook calendar sync successfully!');
                // return redirect('/');
            }
            catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
                return redirect()->route($role_name)->with('error', 'Error requesting access token')->with('errorDetail', json_encode($e->getResponseBody()));
                // return redirect('/')->with('error', 'Error requesting access token')->with('errorDetail', json_encode($e->getResponseBody()));
            }
        }

        return redirect()->route($role_name)->with('error', $request->query('error'))->with('errorDetail', $request->query('error_description'));
        // return redirect('/')->with('error', $request->query('error'))->with('errorDetail', $request->query('error_description'));
    }

    public function signOut(Request $request)
    {
        $request->validate([
            'id' => 'required',
                ], [
            'id.required' => 'Please try again!',
        ]);

        $id = $request->id;

        $token = Token::where('user_id','=',$id)->first();

        if ($token->delete()) {
            return back()->with('success', 'Successfully Outlook Account Disconnected!');
        } else {
            return back()->with('error', 'Please try again!');
        }
        
    }
}
