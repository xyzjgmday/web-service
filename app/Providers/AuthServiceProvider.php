<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // Register Post Policy
        Gate::define('read-post', function ($user) {
            return $user->role == 'editor' || $user->role == 'admin';
        });

        // implementasi untuk function show
        Gate::define('read-post-detail', function ($user, $post) {
            // Admin dapat membaca semua post, editor hanya dapat membaca post yang mereka tulis
            return $user->role === 'admin' || ($user->role === 'editor' && $post->user_id === $user->id);
        });
        

        Gate::define('update-post', function ($user, $post) {
            // check admin atau editor
            if($user->role === 'admin') {
                return true;
            } else if ($user->role == 'editor') {
                return $post->user_id == $user->id;
            } else {
                return false;
            }
        });

        // implementasi admin dan editor untuk create post (function store)
        Gate::define('create-post', function ($user) {
            return $user->role === 'admin' || $user->role === 'editor';
        });

        // Implementasi function destroy
        Gate::define('delete-post', function ($user, $post) {
            // Admin dapat menghapus semua post, editor hanya dapat menghapus post yang mereka tulis
            return $user->role === 'admin' || ($user->role === 'editor' && $post->user_id === $user->id);
        });
        
        

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });
    }
}
