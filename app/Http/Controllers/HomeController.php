<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $projects = $user->projects;
        $project_ids = $user->projects()->pluck('id')->toArray();
        $nonUsers = User::whereDoesntHave('projects', function ($query) use ($project_ids) {
            $query->whereIn('id', $project_ids);
        })->get();


        return view('projects.index', [
            'projects' => $projects, 
            'nonUsers' => $nonUsers,
        ]);
    }
}
