<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;
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

        /*$user = UserProject::find($user_id);
        $projects = $user->projects; */
        //$project_ids = $user->projects()->pluck('id')->toArray();
        /*$nonUsers = User::whereDoesntHave('projects', function ($query) use ($project_ids) {
            $query->whereIn('id', $project_ids);
        })->get(); */

        $nonUsers = User::where('id', '!=', $user_id)
                    ->whereNotIn('id', function ($query) use ($user_id) {
                    $query->select('users.id')
                        ->from('users')
                        ->join('user_project', 'users.id', '=', 'user_project.user_id')
                        ->join('projects', 'user_project.project_id', '=', 'projects.id')
                        ->whereColumn('users.id', '!=', 'user_project.user_id')
                        ->pluck('users.id');
                })->get();

        return view('projects.index', [
            'projects' => $projects, 
            'nonUsers' => $nonUsers,
            'userId' => $user_id
        ]);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'project_description' => 'required|string',
            'project_price' => 'required|numeric',
            'included_tasks' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $project = Project::find($id);
        $project->update($validatedData);
        return redirect()->route('projects.index');
    }

}
