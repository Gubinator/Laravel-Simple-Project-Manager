<?php

use App\Models\Project;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProject;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Projects endpoint 
Route::get('/projects', [ProjectsController::class, 'index']);

Route::delete('/projects/{id}', [ProjectsController::class, 'destroy'])->name('projects.destroy');

Route::put('/projects/{id}', [ProjectsController::class, 'update'])->name('projects.update');

Route::post(
    '/projects',
    function (Request $request) {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'start_date' => 'required|before_or_equal:end_date',
            'end_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return redirect('/projects')
                ->withInput()
                ->withErrors($validator);
        }
        $project = new Project;

        $project->project_name = $request->name;
        $project->project_description = $request->description;
        $project->project_price = $request->price;
        $project->included_tasks = $request->tasks;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->save();


        $user->projects()->attach($user->id, [
            'permission' => 1,
            'project_id' => $project->id
        ]);


        $associates = $request->input('associates');
        if ($associates) {
            foreach ($associates as $associateId) {
                $user->projects()->attach($associateId, [
                    'permission' => 2,
                    'project_id' => $project->id,
                    'user_id' => $associateId
                ]);
            }
        }

        /*$selectedUserIds = array_keys($request->all('user*'));
        foreach ($selectedUserIds as $userId) {
        $user = User::find($userId);
        $user->projects()->attach($project->id, [
        'permission' => 2,
        ]);
        }*/


        /*$user->projects()->attach([1,2],[
        'permission' => 1
        ]);*/
        return redirect('/projects');
    }
);