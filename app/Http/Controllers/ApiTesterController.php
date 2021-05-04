<?php

namespace App\Http\Controllers;

use App\Models\ApiFolder;
use App\Models\ApiItem;
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

    public function createOrUpdateItem(Request $request)
    {
        if ($request->isEdit == false) {
            switch ($request->type) {
                case 'project':
                    $item = ApiProject::create($request->all());
                    $item = ApiProject::find($item->id);
                    break;
                case 'folder':
                    $item = ApiFolder::create($request->all());
                    $item = ApiFolder::find($item->id);
                    break;
                case 'request':
                    $item = ApiItem::create($request->all());
                    break;
            }
        } else {
            switch ($request->type) {
                case 'project':
                    ApiProject::where('id', $request->project_id)->update(['name' => $request->name]);
                    $item = ApiProject::find($request->project_id);
                    break;
                case 'folder':
                    ApiFolder::where('id', $request->folder_id)->update(['name' => $request->name]);
                    $item = ApiFolder::find($request->folder_id);
                    break;
                case 'request':
                    ApiItem::where('id', $request->request_id)->update(['name' => $request->name]);
                    $item = ApiItem::find($request->request_id);
                    break;
            }
        }
        return $item;
    }
}
