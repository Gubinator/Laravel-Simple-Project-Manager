<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\User;

class ProjectsController extends Controller
{
    public function index(){

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $projects = $user->projects;

        if (!session()->has('user')) {
            return redirect('/login');
        }
    
        return view('projects/index', [
            'projects' => $projects
        ]);
    }

    public function addUser(Request $request, $projectId)
{
    $user = Auth::user();
    $project = Project::findOrFail($projectId);
    $project->users()->attach($user); 

    return redirect()->back()->with('success', 'User added successfully');
}

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect('/projects');
    }
}

?>
