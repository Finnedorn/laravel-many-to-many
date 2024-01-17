<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;

use App\Models\Category;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories= Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        //
        $formData = $request->validated();
        $slug = Str::slug($formData['project_title'],'-');
        $formData['slug'] = $slug;

        // formula per la storage dei file img dal campo form "preview"
        if($request->hasFile('preview')) {
            $preview = Storage::put('previews', $formData['preview']);
            $formData['preview'] = $preview;
        }
        $userId = Auth::id();
        $formData['user_id'] = $userId;
        $newProject = Project::create($formData);
        return redirect()->route('admin.projects.show', $newProject->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
        $categories= Category::all();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
        $formData = $request->validated();
        $slug = Str::slug($formData['project_title'],'-');
        $formData['slug'] = $slug;
        $formData['user_id'] = $project->user_id;
        if($request->hasFile('preview')) {
            // uguale a quella dello store ma qua devo specificare di cancellare prima la preview di quel project
            if ($project->preview){
                Storage::delete($project->preview);
            }
            $preview = Storage::put('previews', $formData['preview']);
            $formData['preview'] = $preview;
        }
        $project->update($formData);
        return redirect()->route('admin.projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
        if ($project->preview){
            Storage::delete($project->preview);
        }
        $project->delete();
        return to_route('admin.projects.index')->with('message', "l'elemento $project->project_title è stato eliminato con successo");

    }
}
