<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetGraphServicesByAppRequest;
use App\Models\{Application, Service, AppInstance, AppInstanceDependencies, Hosting};
use Illuminate\Support\Facades\DB;

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
        $mainEnvironnement = AppInstance::select('environnement_id', DB::raw('count(*) as total'))->with('environnement')->orderBy('total','desc')->groupBy('environnement_id')->first();

        return view('infra.index', compact('nbApp','nbInstances','nbServices','nbHostings','mainEnvironnement'));
    }

    /**
     * Get nodes informations for the graph
     */
    public function getGraphServicesByApp(GetGraphServicesByAppRequest $request)
    {

        $nodesData = [];
        //$applications = Application::get();
        $instanceByApplications = AppInstance::select('application_id')->with('application')
                            ->where('environnement_id', $request->environnement_id)
                            ->groupBy('application_id')->get();

        foreach($instanceByApplications as $instanceByApplication)
        {
            $nodesData[] = (object)[
                "group" => "nodes",
                "data" =>(object)[
                    "id" =>  'application_'.$instanceByApplication->application->id ,
                    "name" => $instanceByApplication->application->name
                ],
                "classes" => "application"
            ];
        }
        $instances = AppInstance::with("serviceVersion","application")
                        ->where('environnement_id', $request->environnement_id)
                        ->get() ;

        foreach($instances as $appInstance)
        {
            $appInstance->serviceVersion->load("service");
            // add service instance
            $nodesData[] = (object)[
                "group" => "nodes",
                "data" =>(object)[
                    "id" =>  'appInstance_'.$appInstance->id ,
                    "name" => $appInstance->serviceVersion->service->name,
                    "version" => "v".$appInstance->serviceVersion->version,
                    "parent" => 'application_'.$appInstance->application->id ,
                ],
                "classes" => "appInstance",
            ];

            $appDependencies = AppInstanceDependencies::with(['appInstance' => function($query) use ($request){
                                    $query->where('environnement_id', $request->environnement_id);
                                }])
                                ->with(['appInstanceDep' => function($query) use ($request){
                                    $query->where('environnement_id', $request->environnement_id);
                                }])
                                ->where("instance_id", $appInstance->id)
                                ->get();

            foreach($appDependencies  as $appDep)
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
