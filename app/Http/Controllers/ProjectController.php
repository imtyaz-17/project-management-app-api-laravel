<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //
    public function index(Request $request)
    {
        return ProjectResource::collection($request->user()->projects);
    }

    public function store(ProjectCreateRequest $request)
    {
        $data = $request->validated();
        $project = $request->user()->projects()->create($data);

        return new ProjectResource($project);
    }
    public function show(Project $project)
    {
        $project->load(['boards','boards.tickets']);
        return new ProjectResource($project);
    }
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        $data = $request->validated();
        abort_if($project->user_id !== $request->user()->id, 403,'You are not allowed to update this project');
        $project->update($data);
        return new ProjectResource($project);
    }
    public function destroy(Request $request, Project $project)
    {
        abort_if($project->user_id !== $request->user()->id, 403, "You are not allowed to delete this project");

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully'
        ]);
    }
}
