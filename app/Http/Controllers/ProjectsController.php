<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index(){

        $projects = Project::all();

        return view('projects/index', [
            'projects' => $projects
        ]);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect('/projects');
    }
}

?>
