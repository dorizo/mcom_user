<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // $user = Auth::user();

        // if ($user) {
        //     $user->load('roles');
    
        //     $user = [
        //         'id' => $user->id,
        //         'name' => $user->name,
        //         'phone' => $user->phone,
        //         'akun' => $user->akun,
        //         'email' => $user->email,
        //         'roles' => $user->roles,
        //     ];
        // }
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),

            // Lazily...
            'auth.user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'email','akun' , 'saldo','phone')
                : null,
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'body' => fn () => $request->session()->get('body')
            ],
            'urlPrev'	=> function() {
                if (url()->previous() !== route('login') && url()->previous() !== '' && url()->previous() !== url()->current()) {
		    		return url()->previous();
		    	}else {
		    		return 'empty'; // used in javascript to disable back button behavior
		    	}
		    },
        ]);
    }
}
