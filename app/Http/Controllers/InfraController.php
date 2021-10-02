<?php

namespace App\Http\Controllers;

use App\Models\{Application, Service, AppInstance, AppInstanceDependencies, Hosting};

class InfraController extends Controller
{
    /**
     * Display the IT Infrastructure dashboard
     *
     * @return Response
     */
    public function index()
    {
        $nbApp = Application::count();
        $nbInstances = AppInstance::count();
        $nbServices = Service::count();
        $nbHostings = Hosting::count();

        return view('infra.index', compact('nbApp','nbInstances','nbServices','nbHostings'));
    }

    /**
     * Get nodes informations for the graph
     */
    public function getGraphNodes()
    {

        $nodesData = [];
        foreach(Application::get() as $app)
        {
            $nodesData[] = (object)[
                "group" => "nodes",
                "data" =>(object)[
                    "id" =>  'app_'.$app->id ,
                    "name" => "[#".$app->id."] ".$app->name
                ]
            ];
        }
        foreach( AppInstance::with("serviceVersion","application")->get() as $appInstance)
        {
            $appInstance->serviceVersion->load("service");
            // add service instance
            $nodesData[] = (object)[
                "group" => "nodes",
                "data" =>(object)[
                    "id" =>  'appInstance_'.$appInstance->id ,
                    "name" => "[#".$appInstance->id."] ".$appInstance->serviceVersion->service->name." - v".$appInstance->serviceVersion->version,
                    "parent" => 'app_'.$appInstance->application->id ,
                ],
                "classes" => "appInstance",
            ];

            foreach( AppInstanceDependencies::where("instance_id", $appInstance->id)->get() as $appDep)
            {
                // add dependencies
                $nodesData[] = (object)[
                    "group" => "edges",
                    "data" =>(object)[
                        "id" =>  'dep_'.$appInstance->id."_".$appDep->id ,
                        "source" => "appInstance_".$appInstance->id,
                        "target" => 'appInstance_'.$appDep->instance_dep_id ,
                    ]
                ];
            }
        }

        return response()->json($nodesData);
    }
}
