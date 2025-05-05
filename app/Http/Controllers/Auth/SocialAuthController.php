<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Laravel\Fortify\Contracts\LoginResponse;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        try {
            if (!array_key_exists($provider, config('services'))) {
                abort(404);
            }

            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'auth' => 'Erro ao redirecionar para ' . ucfirst($provider) . '. Tente novamente.'
            ]);
        }
    }

    public function handleProviderCallback($provider, LoginResponse $loginResponse)
    {
        try {
            if (!array_key_exists($provider, config('services'))) {
                abort(404);
            }

            $socialUser = Socialite::driver($provider)->stateless()->setHttpClient(new \GuzzleHttp\Client([
                'verify' => false,
            ]))->user();

            $user = User::updateOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'email_verified_at' => now(),
                    'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                    'password' => bcrypt(Str::random(24)),
                ]
            );
            
            $response = Http::get($socialUser->getAvatar());

            if ($response->ok()) {
                $contents = $response->body();

                $tmpFilePath = tempnam(sys_get_temp_dir(), 'avatar_');
                file_put_contents($tmpFilePath, $contents);
            
                $uploadedFile = new UploadedFile(
                    $tmpFilePath,
                    Str::uuid() . '.jpg',
                    'image/jpeg',
                    null,
                    true
                );

                $user->updateProfilePhoto($uploadedFile);

                @unlink($tmpFilePath);
            }

            Auth::login($user, true);

            return $loginResponse->toResponse(request());
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'auth' => 'Erro ao autenticar com ' . ucfirst($provider) . '. Tente novamente.'
            ]);
        } 
    }
}
