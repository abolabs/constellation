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
     * Display the IT Infrastructure dashboard
     *
     * @return Response
     */
    public function displayByApp()
    {
        $mainEnvironnement = AppInstance::select('environnement_id', DB::raw('count(*) as total'))->with('environnement')->orderBy('total','desc')->groupBy('environnement_id')->first();

        return view('infra.byApp', compact('mainEnvironnement'));
    }


    public function displayByHosting()
    {
        $mainEnvironnement = AppInstance::select('environnement_id', DB::raw('count(*) as total'))->with('environnement')->orderBy('total','desc')->groupBy('environnement_id')->first();

        return view('infra.byHosting', compact('mainEnvironnement'));
    }

    /**
     * Get nodes informations for the graph
     */
    public function getGraphServicesByApp(GetGraphServicesByAppRequest $request)
    {

        $nodesData = [];

        $instanceByApplicationsQuery = AppInstance::select('application_id')->with('application')
                            ->where('environnement_id', $request->environnement_id);

        // app filter
        if(!empty($request->application_id)){
            $instanceByApplicationsQuery->whereIn('application_id', $request->application_id );
        }
        if(!empty($request->hosting_id)){
            $instanceByApplicationsQuery->whereIn('hosting_id', $request->hosting_id );
        }
        $instanceByApplications =  $instanceByApplicationsQuery->groupBy('application_id')->get();

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
        $instancesQuery = AppInstance::with("serviceVersion","application","hosting")
                        ->where('environnement_id', $request->environnement_id);

        // app filter
        if(!empty($request->application_id)){
            $instancesQuery->whereIn('application_id', $request->application_id );
        }
        if(!empty($request->hosting_id)){
            $instancesQuery->whereIn('hosting_id', $request->hosting_id );
        }
        $instances = $instancesQuery->get() ;

        foreach($instances as $appInstance)
        {
            $appInstance->serviceVersion->load("service");

            $classStatut = "";
            if($appInstance->statut === false){
                $classStatut = "disabled";
            }

            if($request->tag == 'hosting'){
                $tag = $appInstance->hosting->name;
            }else{
                $tag = "v".$appInstance->serviceVersion->version;
            }

            // add service instance
            $nodesData[] = (object)[
                "group" => "nodes",
                "data" =>(object)[
                    "id" =>  'appInstance_'.$appInstance->id ,
                    "name" => $appInstance->serviceVersion->service->name,
                    "tag" => $tag,
                    "parent" => 'application_'.$appInstance->application->id ,
                ],
                "classes" => "appInstance ".$classStatut,
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

    /**
     * Get nodes informations for the graph
     */
    public function getGraphServicesByHosting(GetGraphServicesByAppRequest $request)
    {

        $nodesData = [];

        $instanceByHostingsQuery = AppInstance::select('hosting_id')->with('hosting')
                            ->where('environnement_id', $request->environnement_id);
        // app filter
        if(!empty($request->application_id)){
            $instanceByHostingsQuery->whereIn('application_id', $request->application_id );
        }
        if(!empty($request->hosting_id)){
            $instanceByHostingsQuery->whereIn('hosting_id', $request->hosting_id );
        }
        $instanceByHostings =  $instanceByHostingsQuery->groupBy('hosting_id')->get();

        foreach($instanceByHostings as $instanceByHosting)
        {
            $nodesData[] = (object)[
                "group" => "nodes",
                "data" =>(object)[
                    "id" =>  'hosting_'.$instanceByHosting->hosting->id ,
                    "name" => $instanceByHosting->hosting->name
                ],
                "classes" => "hosting"
            ];
        }
        $instancesQuery = AppInstance::with("serviceVersion","application")
                        ->where('environnement_id', $request->environnement_id);
        // app filter
        if(!empty($request->application_id)){
            $instancesQuery->whereIn('application_id', $request->application_id );
        }
        if(!empty($request->hosting_id)){
            $instancesQuery->whereIn('hosting_id', $request->hosting_id );
        }

        $instances = $instancesQuery->get() ;

        foreach($instances as $appInstance)
        {
            $appInstance->serviceVersion->load("service");

            if($request->tag == 'application'){
                $tag = $appInstance->application->name;
            }else{
                $tag = "v".$appInstance->serviceVersion->version;
            }

            $classStatut = "";
            if($appInstance->statut === false){
                $classStatut = "disabled";
            }

            // add service instance
            $nodesData[] = (object)[
                "group" => "nodes",
                "data" =>(object)[
                    "id" =>  'appInstance_'.$appInstance->id ,
                    "name" => $appInstance->serviceVersion->service->name,
                    "tag" => $tag,
                    "parent" => 'hosting_'.$appInstance->hosting->id ,
                ],
                "classes" => "appInstance ".$classStatut,
            ];

            $appDependencies = AppInstanceDependencies::join('app_instance as source' , function($query) use ($request){
                                    $query->on('source.id', '=', 'app_instance_dep.instance_id');

                                    $query->where('source.environnement_id', $request->environnement_id);
                                    if(!empty($request->application_id)){
                                        $query->whereIn('source.application_id', $request->application_id );
                                    }
                                    if(!empty($request->hosting_id)){
                                        $query->whereIn('source.hosting_id', $request->hosting_id );
                                    }
                                })
                                ->join('app_instance as target' , function($query) use ($request){
                                    $query->on('target.id', '=', 'app_instance_dep.instance_dep_id');

                                    $query->where('target.environnement_id', $request->environnement_id);
                                    if(!empty($request->application_id)){
                                        $query->whereIn('target.application_id', $request->application_id );
                                    }
                                    if(!empty($request->hosting_id)){
                                        $query->whereIn('target.hosting_id', $request->hosting_id );
                                    }
                                })
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
