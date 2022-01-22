<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetGraphServicesByAppRequest;
use App\Models\Application;
use App\Models\Hosting;
use App\Models\Service;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use Illuminate\Database\Eloquent\Builder;

class InfraController extends Controller
{
    /**
     * Display the IT Infrastructure dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $nbApp = Application::count();
        $nbInstances = ServiceInstance::count();
        $nbServices = Service::count();
        $nbHostings = Hosting::count();
        $mainEnvironnement = ServiceInstance::getMainEnvironnement();

        return view('infra.index', compact('nbApp', 'nbInstances', 'nbServices', 'nbHostings', 'mainEnvironnement'));
    }

    /**
     * Display App Map.
     *
     * @return Response
     */
    public function displayAppMap()
    {
        $mainEnvironnement = ServiceInstance::getMainEnvironnement();

        return view('infra.AppMap', compact('mainEnvironnement'));
    }

    /**
     * Display the IT Infrastructure dashboard.
     *
     * @return Response
     */
    public function displayByApp()
    {
        $mainEnvironnement = ServiceInstance::getMainEnvironnement();

        return view('infra.byApp', compact('mainEnvironnement'));
    }

    /**
     * Display App map by hosting solution.
     *
     * @return Response
     */
    public function displayByHosting()
    {
        $mainEnvironnement = ServiceInstance::getMainEnvironnement();

        return view('infra.byHosting', compact('mainEnvironnement'));
    }

    /**
     * Get nodes informations for the graph.
     */
    public function getGraphByApp(GetGraphServicesByAppRequest $request)
    {
        $nodesData = [];

        $instanceByApplicationsQuery = ServiceInstance::select('application_id')->with(['application'])
                            ->where('environnement_id', $request->environnement_id);

        // app filter
        if (! empty($request->application_id)) {
            $instanceByApplicationsQuery->whereIn('application_id', $request->application_id);
        }
        if (! empty($request->team_id)) {
            $instanceByApplicationsQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (! empty($request->hosting_id)) {
            $instanceByApplicationsQuery->whereIn('hosting_id', $request->hosting_id);
        }
        $instanceByApplications = $instanceByApplicationsQuery->groupBy('application_id')->get();

        foreach ($instanceByApplications as $instanceByApplication) {
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' =>  'application_' . $instanceByApplication->application->id,
                    'name' => $instanceByApplication->application->name,
                ],
                'classes' => 'serviceInstance',
            ];
        }

        $depByApp = ServiceInstanceDependencies::select(['source.application_id as source_app_id', 'target.application_id as target_app_id', 'level'])
        ->join('service_instance as source', function ($query) use ($request) {
            $query->on('source.id', '=', 'service_instance_dep.instance_id');

            $query->where('source.environnement_id', $request->environnement_id);
            if (! empty($request->application_id)) {
                $query->whereIn('source.application_id', $request->application_id);
            }
        })
        ->join('service_instance as target', function ($query) use ($request) {
            $query->on('target.id', '=', 'service_instance_dep.instance_dep_id');

            $query->where('target.environnement_id', $request->environnement_id);
            if (! empty($request->application_id)) {
                $query->whereIn('target.application_id', $request->application_id);
            }
        });
        if (! empty($request->team_id)) {
            $depByApp->whereHas('serviceInstance.application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (! empty($request->application_id)) {
            $depByApp->whereIn('source.application_id', $request->application_id);
            $depByApp->whereIn('target.application_id', $request->application_id);
        }
        $appDeps = $depByApp->whereRaw('source.application_id != target.application_id')
                ->groupBy(['source.application_id', 'target.application_id', 'level'])->orderBy('level', 'desc')->get();

        foreach ($appDeps as $appDep) {
            // add dependencies
            $nodesData[] = (object) [
                'group' => 'edges',
                'data' => (object) [
                    'id' =>  'dep_' . $appDep->source_app_id . '_' . $appDep->target_app_id,
                    'source' => 'application_' . $appDep->source_app_id,
                    'target' => 'application_' . $appDep->target_app_id,
                ],
                'classes' => 'level_' . $appDep->level,
            ];
        }

        return response()->json($nodesData);
    }

    /**
     * Get nodes informations for the graph.
     */
    public function getGraphServicesByApp(GetGraphServicesByAppRequest $request)
    {
        $nodesData = [];

        $instanceByApplicationsQuery = ServiceInstance::select('application_id')->with('application')
                            ->where('environnement_id', $request->environnement_id);

        // app filter
        if (! empty($request->application_id)) {
            $instanceByApplicationsQuery->whereIn('application_id', $request->application_id);
        }
        if (! empty($request->team_id)) {
            $instanceByApplicationsQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (! empty($request->hosting_id)) {
            $instanceByApplicationsQuery->whereIn('hosting_id', $request->hosting_id);
        }
        $instanceByApplications = $instanceByApplicationsQuery->groupBy('application_id')->get();

        foreach ($instanceByApplications as $instanceByApplication) {
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' =>  'application_' . $instanceByApplication->application->id,
                    'name' => $instanceByApplication->application->name,
                ],
                'classes' => 'application container',
            ];
        }
        $instancesQuery = ServiceInstance::with('serviceVersion', 'application', 'hosting')
                        ->where('environnement_id', $request->environnement_id);

        // app filter
        if (! empty($request->application_id)) {
            $instancesQuery->whereIn('application_id', $request->application_id);
        }
        if (! empty($request->team_id)) {
            $instancesQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (! empty($request->hosting_id)) {
            $instancesQuery->whereIn('hosting_id', $request->hosting_id);
        }
        $instances = $instancesQuery->get();

        foreach ($instances as $serviceInstance) {
            $serviceInstance->serviceVersion->load('service');

            $classStatut = '';
            if ($serviceInstance->statut === false) {
                $classStatut = 'disabled';
            }

            switch($request->tag){
                case 'hosting':
                    $tag = $serviceInstance->hosting->name;
                    break;
                case 'version':
                    $tag = 'v' . $serviceInstance->serviceVersion->version;
                    break;
                default:
                    $tag = "";
                    break;
            }

            // add service instance
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' =>  'serviceInstance_' . $serviceInstance->id,
                    'name' => $serviceInstance->serviceVersion->service->name,
                    'tag' => $tag,
                    'parent' => 'application_' . $serviceInstance->application->id,
                ],
                'classes' => 'serviceInstance ' . $classStatut,
            ];

            $appDependencies = $this->getServiceInstanceDependencies($request, $serviceInstance);
            $this->generateEdges($nodesData, $appDependencies, $serviceInstance);
        }

        return response()->json($nodesData);
    }

    /**
     * Get nodes informations for the graph.
     */
    public function getGraphServicesByHosting(GetGraphServicesByAppRequest $request)
    {
        $nodesData = [];

        $instanceByHostingsQuery = ServiceInstance::select('hosting_id')->with('hosting')
                            ->where('environnement_id', $request->environnement_id);
        // app filter
        if (! empty($request->application_id)) {
            $instanceByHostingsQuery->whereIn('application_id', $request->application_id);
        }
        if (! empty($request->team_id)) {
            $instanceByHostingsQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (! empty($request->hosting_id)) {
            $instanceByHostingsQuery->whereIn('hosting_id', $request->hosting_id);
        }
        $instanceByHostings = $instanceByHostingsQuery->groupBy('hosting_id')->get();

        foreach ($instanceByHostings as $instanceByHosting) {
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' =>  'hosting_' . $instanceByHosting->hosting->id,
                    'name' => $instanceByHosting->hosting->name,
                ],
                'classes' => 'hosting container',
            ];
        }
        $instancesQuery = ServiceInstance::with('serviceVersion', 'application')
                        ->where('environnement_id', $request->environnement_id);
        // app filter
        if (! empty($request->application_id)) {
            $instancesQuery->whereIn('application_id', $request->application_id);
        }
        if (! empty($request->team_id)) {
            $instancesQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (! empty($request->hosting_id)) {
            $instancesQuery->whereIn('hosting_id', $request->hosting_id);
        }

        $instances = $instancesQuery->get();

        foreach ($instances as $serviceInstance) {
            $serviceInstance->serviceVersion->load('service');

            switch($request->tag){
                case 'application':
                    $tag = $serviceInstance->application->name;
                    break;
                case 'version':
                    $tag = 'v' . $serviceInstance->serviceVersion->version;
                    break;
                default:
                    $tag = "";
                    break;
            }

            $classStatut = '';
            if ($serviceInstance->statut === false) {
                $classStatut = 'disabled';
            }

            // add service instance
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' =>  'serviceInstance_' . $serviceInstance->id,
                    'name' => $serviceInstance->serviceVersion->service->name,
                    'tag' => $tag,
                    'parent' => 'hosting_' . $serviceInstance->hosting->id,
                ],
                'classes' => 'serviceInstance ' . $classStatut,
            ];

            $appDependencies = $this->getServiceInstanceDependencies($request, $serviceInstance);
            $this->generateEdges($nodesData, $appDependencies, $serviceInstance);
        }

        return response()->json($nodesData);
    }

    /**
     * Generate edges data.
     *
     * @param  array  &$nodesData
     * @param  iterable  $appDependencies
     * @param  ServiceInstance  $serviceInstance
     * @return void
     */
    private function generateEdges(array &$nodesData, iterable $appDependencies, ServiceInstance $serviceInstance): void
    {
        foreach ($appDependencies as $appDep) {
            // add dependencies
            $nodesData[] = (object) [
                'group' => 'edges',
                'data' => (object) [
                    'id' =>  'dep_' . $serviceInstance->id . '_' . $appDep->id,
                    'source' => 'serviceInstance_' . $serviceInstance->id,
                    'target' => 'serviceInstance_' . $appDep->instance_dep_id,
                ],
                'classes' => 'level_' . $appDep->level,
            ];
        }
    }

    /**
     * Load dependencies.
     */
    private function getServiceInstanceDependencies(GetGraphServicesByAppRequest $request, $serviceInstance)
    {
        $depQuery = ServiceInstanceDependencies::join('service_instance as source', function ($query) use ($request) {
            $query->on('source.id', '=', 'service_instance_dep.instance_id');

            $query->where('source.environnement_id', $request->environnement_id);
            if (! empty($request->application_id)) {
                $query->whereIn('source.application_id', $request->application_id);
            }
            if (! empty($request->hosting_id)) {
                $query->whereIn('source.hosting_id', $request->hosting_id);
            }
        })
        ->join('service_instance as target', function ($query) use ($request) {
            $query->on('target.id', '=', 'service_instance_dep.instance_dep_id');

            $query->where('target.environnement_id', $request->environnement_id);
            if (! empty($request->application_id)) {
                $query->whereIn('target.application_id', $request->application_id);
            }
            if (! empty($request->hosting_id)) {
                $query->whereIn('target.hosting_id', $request->hosting_id);
            }
        })
        ->where('instance_id', $serviceInstance->id);

        if (! empty($request->team_id)) {
            $depQuery->whereHas('serviceInstance.application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        return $depQuery->get();
    }
}
