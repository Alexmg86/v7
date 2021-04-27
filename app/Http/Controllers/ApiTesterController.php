<?php

namespace App\Http\Controllers;

use App\Models\ApiProject;
use Illuminate\Http\Request;

class ApiTesterController extends Controller
{
    public function index()
    {
        $projects = ApiProject::all();
        return view('apitester', compact('projects'));
    }

    public function action(Request $request)
    {
        $action = $request->action;
        return $this->$action($request);
    }

    public function createProject(Request $request)
    {
        return ApiProject::create($request->all());
    }
}
