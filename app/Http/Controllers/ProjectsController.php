<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\User;
use App\Models\UserProject;

class ProjectsController extends Controller
{
    public function index()
    {

        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $projects = $user->projects;

        if (!session()->has('user')) {
            return redirect('/login');
        }


        $nonUsers = User::whereNotIn('id', function ($query) {
            $user_id = auth()->user()->id;
            $query->select('users.id')
                ->from('users')
                ->join('user_project', 'users.id', '=', 'user_project.user_id')
                ->join('projects', 'user_project.project_id', '=', 'projects.id')
                ->where('users.id', $user_id)
                ->pluck('users.id');
        })->get();


        return view('projects/index', [
            'projects' => $projects,
            'nonUsers' => $nonUsers,
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

        $project = Project::findOrFail($id);
        $project->update($validatedData);
        return redirect('/projects');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect('/projects');
    }
}

?>