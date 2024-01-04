<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    //CREATE PROJECT API
    public function createProject(Request $request)
    {
        //validation
        $request->validate([
            "name",
            "description",
            "duration"
        ]);
        //get student id and create a project
        $student_id = auth()->user()->id;

        $project = new Project();

        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;

        $project->save();


        //send a response
        return response()->json([
            "status" => 1,
            "message" => "Project has been created successfully"
        ]);
    }

    //LIST PROJECTS API
    public function listProject()
    {
        $student_id = auth()->user()->id;

        $projects = Project::where("student_id", $student_id)->get();
        return response()->json([
            "status" => 1,
            "message" => "Projects",
            "Data" => $projects
        ]);
    }

    //SINGLE PROJECT API
    public function singleProject($id)
    {
        $student_id = auth()->user()->id;

        if (Project::where([
            "student_id" => $student_id,
            "id" => $id

        ])->exists()) {
            $details = Project::where([
                "id" => $id,
                "student_id" => $student_id
            ])->first();

            return response()->json([
                "status" => 1,
                "message" => "Project details",
                "data" => $details
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Project not found"
            ]);
        }
    }

    //DELETE PROJECT API
    public function deleteProject($id)
    {
        $student_id = auth()->user()->id;

        if (Project::where([
            "id" => $id,
            "student_id" => $student_id
        ])->exists()) {
            $project = Project::where([
                "id" => $id,
                "student_id" => $student_id
            ])->first();

            $project->delete();

            return response()->json([
                "status" => 1,
                "message" => "Project deleted successfully"
            ]);
        } else {
            return response([
                "status" => 0,
                "Message" => "project not found"
            ]);
        }
    }
}
