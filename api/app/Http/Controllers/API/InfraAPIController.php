<?php

// Copyright (C) 2022 Abolabs (https://gitlab.com/abolabs/)
//
// This program is free software: you can redistribute it and/or modify
// it under the terms of the GNU Affero General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU Affero General Public License for more details.
//
// You should have received a copy of the GNU Affero General Public License
// along with this program.  If not, see <http://www.gnu.org/licenses/>.

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\OAT\Responses\SuccessMappingNodesResponse;
use App\Http\OAT\Responses\SuccessMappingPerServiceResponse;
use App\Http\Requests\API\GetGraphServicesByAppAPIRequest;
use App\Models\Application;
use App\Models\Hosting;
use App\Models\Service;
use App\Models\ServiceInstance;
use App\Models\ServiceInstanceDependencies;
use Illuminate\Database\Eloquent\Builder;
use OpenApi\Attributes as OAT;

class InfraAPIController extends AppBaseController
{
    /**
     * Display the IT Infrastructure dashboard.
     */
    #[OAT\Get(
        path: '/v1/application-mapping/dashboard',
        operationId: 'getMainMetrics',
        summary: "Display the main data and metrics.",
        description: "Get the main environment, the number of: hostings, services, instances, applications.",
        tags: ["Mapping"],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Success',
                content: new OAT\JsonContent(
                    type: 'object',
                    properties: [
                        new OAT\Property(property: 'success', type: 'boolean'),
                        new OAT\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OAT\Property(
                                    property: 'mainEnvironment',
                                    type: 'object',
                                    properties: [
                                        new OAT\Property(property: 'environment_id', type: 'integer'),
                                        new OAT\Property(property: 'total', type: 'integer'),
                                        new OAT\Property(
                                            property: 'environment',
                                            ref: '#/components/schemas/resource-environment'
                                        )
                                    ]
                                ),
                                new OAT\Property(property: 'nbHostings', type: 'integer'),
                                new OAT\Property(property: 'nbServices', type: 'integer'),
                                new OAT\Property(property: 'nbInstances', type: 'integer'),
                                new OAT\Property(property: 'nbApp', type: 'integer'),
                            ]
                        ),
                        new OAT\Property(property: 'message', type: 'string'),
                        new OAT\Property(property: 'total', type: 'int'),
                    ]
                ),
            )
        ]
    )]
    public function index()
    {
        $nbApp = Application::count();
        $nbInstances = ServiceInstance::count();
        $nbServices = Service::count();
        $nbHostings = Hosting::count();
        $mainEnvironment = ServiceInstance::getMainEnvironment();

        return $this->sendResponse(
            result: collect([
                'mainEnvironment' => $mainEnvironment,
                'nbHostings' => $nbHostings,
                'nbServices' => $nbServices,
                'nbInstances' => $nbInstances,
                'nbApp' => $nbApp,
            ]),
            message: 'Mapping data retrieved successfully'
        );
    }

    /**
     * Get the dependencies mapping per application
     */
    #[OAT\Get(
        path: '/v1/application-mapping/by-app',
        operationId: 'getMappingByApp',
        summary: "Retrieve the application dependencies mapping.",
        description: "Used to build the application mapping view.",
        tags: ["Mapping"],
        responses: [
            new OAT\Response(
                response: 200,
                description: 'Success',
                content: new OAT\JsonContent(
                    type: 'object',
                    properties: [
                        new OAT\Property(property: 'success', type: 'boolean'),
                        new OAT\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OAT\Property(property: 'environment_id', type: 'int'),
                                new OAT\Property(property: 'total', type: 'int'),
                                new OAT\Property(
                                    property: 'environment',
                                    ref: '#/components/schemas/resource-environment'
                                )
                            ]
                        ),
                        new OAT\Property(property: 'message', type: 'string'),

                    ]
                ),
            )
        ]
    )]
    public function displayByApp()
    {
        $mainEnvironment = ServiceInstance::getMainEnvironment();

        return $this->sendResponse(
            result: collect($mainEnvironment),
            message: 'Mapping data successfully retrieved'
        );
    }

    /**
     * Get nodes informations per application
     */
    #[OAT\Get(
        path: '/v1/application-mapping/graph-nodes-app-map',
        operationId: 'getAppMapping',
        summary: "Retrieve the application dependencies mapping.",
        description: "Used to build the application mapping view.",
        tags: ["Mapping"],
        parameters: [
            new OAT\Parameter(
                name: "environment_id",
                description: "Filter by environment id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "application_id",
                description: "Filter by application id.",
                in: 'query',
                schema: new OAT\Schema(
                    type: "array",
                    items: new OAT\Items(type: "integer")
                )
            ),
            new OAT\Parameter(
                name: "team_id",
                description: "Filter by team id.",
                in: 'query',
                schema: new OAT\Schema(
                    type: "array",
                    items: new OAT\Items(type: "integer")
                )
            ),
        ],
        responses: [
            new SuccessMappingNodesResponse("Success")
        ]
    )]
    public function getGraphByApp(GetGraphServicesByAppAPIRequest $request)
    {
        $nodesData = [];

        $instanceByApplicationsQuery = ServiceInstance::select('application_id')->with(['application'])
            ->where('environment_id', $request->environment_id);

        // app filter
        if (!empty($request->application_id)) {
            $instanceByApplicationsQuery->whereIn('application_id', $request->application_id);
        }
        if (!empty($request->team_id)) {
            $instanceByApplicationsQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (!empty($request->hosting_id)) {
            $instanceByApplicationsQuery->whereIn('hosting_id', $request->hosting_id);
        }
        $instanceByApplications = $instanceByApplicationsQuery->groupBy('application_id')->get();

        foreach ($instanceByApplications as $instanceByApplication) {
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' => 'applications_' . $instanceByApplication->application->id,
                    'name' => $instanceByApplication->application->name,
                ],
                'classes' => 'serviceInstance',
            ];
        }

        $depByApp = ServiceInstanceDependencies::select([
            'source.application_id as source_app_id',
            'target.application_id as target_app_id',
            'level'
        ])
            ->join('service_instance as source', function ($query) use ($request) {
                $query->on('source.id', '=', 'service_instance_dep.instance_id');

                $query->where('source.environment_id', $request->environment_id);
                if (!empty($request->application_id)) {
                    $query->whereIn('source.application_id', $request->application_id);
                }
            })
            ->join('service_instance as target', function ($query) use ($request) {
                $query->on('target.id', '=', 'service_instance_dep.instance_dep_id');

                $query->where('target.environment_id', $request->environment_id);
                if (!empty($request->application_id)) {
                    $query->whereIn('target.application_id', $request->application_id);
                }
            });
        if (!empty($request->team_id)) {
            $depByApp->whereHas('serviceInstance.application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (!empty($request->application_id)) {
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
                    'id' => 'dep_' . $appDep->source_app_id . '_' . $appDep->target_app_id,
                    'source' => 'applications_' . $appDep->source_app_id,
                    'target' => 'applications_' . $appDep->target_app_id,
                ],
                'classes' => 'level_' . $appDep->level,
            ];
        }

        return $this->sendResponse(
            result: $nodesData,
            message: 'Mapping data successfully retrieved'
        );
    }

    /**
     * Get service instance dependencies per application
     */
    #[OAT\Get(
        path: '/v1/application-mapping/graph-nodes-by-app',
        operationId: 'getMappingNodesByApp',
        summary: "Retrieve the service instance dependencies mapping per application.",
        description: "Used to build the service mapping view.",
        tags: ["Mapping"],
        parameters: [
            new OAT\Parameter(
                name: "environment_id",
                description: "Filter by environment id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "application_id",
                description: "Filter by application id.",
                in: 'query',
                schema: new OAT\Schema(
                    type: "array",
                    items: new OAT\Items(type: "integer")
                )
            ),
            new OAT\Parameter(
                name: "team_id",
                description: "Filter by team id.",
                in: 'query',
                schema: new OAT\Schema(
                    type: "array",
                    items: new OAT\Items(type: "integer")
                )
            ),
            new OAT\Parameter(
                name: "hosting_id",
                description: "Filter by hosting id.",
                in: 'query',
                schema: new OAT\Schema(
                    type: "array",
                    items: new OAT\Items(type: "integer")
                )
            ),
        ],
        responses: [
            new SuccessMappingPerServiceResponse("Success")
        ]
    )]
    public function getGraphServicesByApp(GetGraphServicesByAppAPIRequest $request)
    {
        $nodesData = [];

        $instanceByApplicationsQuery = ServiceInstance::select('application_id')->with('application')
            ->where('environment_id', $request->environment_id);

        // app filter
        if (!empty($request->application_id)) {
            $instanceByApplicationsQuery->whereIn('application_id', $request->application_id);
        }
        if (!empty($request->team_id)) {
            $instanceByApplicationsQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (!empty($request->hosting_id)) {
            $instanceByApplicationsQuery->whereIn('hosting_id', $request->hosting_id);
        }
        $instanceByApplications = $instanceByApplicationsQuery->groupBy('application_id')->get();

        foreach ($instanceByApplications as $instanceByApplication) {
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' => 'applications_' . $instanceByApplication->application->id,
                    'name' => $instanceByApplication->application->name,
                ],
                'classes' => 'application container',
            ];
        }
        $instancesQuery = ServiceInstance::with('serviceVersion', 'application', 'hosting')
            ->where('environment_id', $request->environment_id);

        // app filter
        if (!empty($request->application_id)) {
            $instancesQuery->whereIn('application_id', $request->application_id);
        }
        if (!empty($request->team_id)) {
            $instancesQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (!empty($request->hosting_id)) {
            $instancesQuery->whereIn('hosting_id', $request->hosting_id);
        }
        $instances = $instancesQuery->get();

        foreach ($instances as $serviceInstance) {
            $serviceInstance->serviceVersion->load('service');

            $classStatut = '';
            if ($serviceInstance->statut === false) {
                $classStatut = 'disabled';
            }

            switch ($request->tag) {
                case 'hosting':
                    $tag = $serviceInstance->hosting->name;
                    break;
                case 'version':
                    $tag = 'v' . $serviceInstance->serviceVersion->version;
                    break;
                default:
                    $tag = '';
                    break;
            }

            // add service instance
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' => 'service_instances_' . $serviceInstance->id,
                    'name' => $serviceInstance->serviceVersion?->service?->name,
                    'tag' => $tag,
                    'parent' => 'applications_' . $serviceInstance?->application?->id,
                ],
                'classes' => 'serviceInstance ' . $classStatut,
            ];

            $appDependencies = $this->getServiceInstanceDependencies($request, $serviceInstance);
            $this->generateEdges($nodesData, $appDependencies, $serviceInstance);
        }

        return $this->sendResponse(
            result: $nodesData,
            message: 'Mapping data retrieved successfully'
        );
    }

    /**
     * Get nodes informations for the graph.
     */
    #[OAT\Get(
        path: '/v1/application-mapping/graph-nodes-by-hosting',
        operationId: 'getMappingNodesByHosting',
        summary: "Retrieve the service instances dependencies mapping per hosting.",
        description: "Used to build the hosting mapping view.",
        tags: ["Mapping"],
        parameters: [
            new OAT\Parameter(
                name: "environment_id",
                description: "Filter by environment id.",
                in: 'query',
                schema: new OAT\Schema(type: "integer")
            ),
            new OAT\Parameter(
                name: "application_id",
                description: "Filter by application id.",
                in: 'query',
                schema: new OAT\Schema(
                    type: "array",
                    items: new OAT\Items(type: "integer")
                )
            ),
            new OAT\Parameter(
                name: "team_id",
                description: "Filter by team id.",
                in: 'query',
                schema: new OAT\Schema(
                    type: "array",
                    items: new OAT\Items(type: "integer")
                )
            ),
            new OAT\Parameter(
                name: "hosting_id",
                description: "Filter by hosting id.",
                in: 'query',
                schema: new OAT\Schema(
                    type: "array",
                    items: new OAT\Items(type: "integer")
                )
            ),
        ],
        responses: [
            new SuccessMappingPerServiceResponse("Success")
        ]
    )]
    public function getGraphServicesByHosting(GetGraphServicesByAppAPIRequest $request)
    {
        $nodesData = [];

        $instanceByHostingsQuery = ServiceInstance::select('hosting_id')->with('hosting')
            ->where('environment_id', $request->environment_id);
        // app filter
        if (!empty($request->application_id)) {
            $instanceByHostingsQuery->whereIn('application_id', $request->application_id);
        }
        if (!empty($request->team_id)) {
            $instanceByHostingsQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (!empty($request->hosting_id)) {
            $instanceByHostingsQuery->whereIn('hosting_id', $request->hosting_id);
        }
        $instanceByHostings = $instanceByHostingsQuery->groupBy('hosting_id')->get();

        foreach ($instanceByHostings as $instanceByHosting) {
            $nodesData[] = (object) [
                'group' => 'nodes',
                'data' => (object) [
                    'id' => 'hosting_' . $instanceByHosting->hosting->id,
                    'name' => $instanceByHosting->hosting->name,
                ],
                'classes' => 'hosting container',
            ];
        }
        $instancesQuery = ServiceInstance::with('serviceVersion', 'application')
            ->where('environment_id', $request->environment_id);
        // app filter
        if (!empty($request->application_id)) {
            $instancesQuery->whereIn('application_id', $request->application_id);
        }
        if (!empty($request->team_id)) {
            $instancesQuery->whereHas('application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }
        if (!empty($request->hosting_id)) {
            $instancesQuery->whereIn('hosting_id', $request->hosting_id);
        }

        $instances = $instancesQuery->get();

        foreach ($instances as $serviceInstance) {
            $serviceInstance->serviceVersion->load('service');

            switch ($request->tag) {
                case 'application':
                    $tag = $serviceInstance->application->name;
                    break;
                case 'version':
                    $tag = 'v' . $serviceInstance->serviceVersion->version;
                    break;
                default:
                    $tag = '';
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
                    'id' => 'service_instances_' . $serviceInstance->id,
                    'name' => $serviceInstance?->serviceVersion?->service?->name,
                    'tag' => $tag,
                    'parent' => 'hosting_' . $serviceInstance?->hosting?->id,
                ],
                'classes' => 'serviceInstance ' . $classStatut,
            ];

            $appDependencies = $this->getServiceInstanceDependencies($request, $serviceInstance);
            $this->generateEdges($nodesData, $appDependencies, $serviceInstance);
        }

        return $this->sendResponse(
            result: $nodesData,
            message: 'Mapping data retrieved successfully'
        );
    }

    /**
     * Generate edges data.
     *
     * @param  ServiceInstance  $serviceInstance
     */
    private function generateEdges(
        array &$nodesData,
        iterable $appDependencies,
        ServiceInstance|Builder $serviceInstance
    ): void {
        foreach ($appDependencies as $appDep) {
            // add dependencies
            $nodesData[] = (object) [
                'group' => 'edges',
                'data' => (object) [
                    'id' => 'dep_' . $serviceInstance->id . '_' . $appDep->id,
                    'source' => 'service_instances_' . $serviceInstance->id,
                    'target' => 'service_instances_' . $appDep->instance_dep_id,
                ],
                'classes' => 'level_' . $appDep->level,
            ];
        }
    }

    /**
     * Load dependencies.
     */
    private function getServiceInstanceDependencies(GetGraphServicesByAppAPIRequest $request, $serviceInstance)
    {
        $depQuery = ServiceInstanceDependencies::join('service_instance as source', function ($query) use ($request) {
            $query->on('source.id', '=', 'service_instance_dep.instance_id');

            $query->where('source.environment_id', $request->environment_id);
            if (!empty($request->application_id)) {
                $query->whereIn('source.application_id', $request->application_id);
            }
            if (!empty($request->hosting_id)) {
                $query->whereIn('source.hosting_id', $request->hosting_id);
            }
        })
            ->join('service_instance as target', function ($query) use ($request) {
                $query->on('target.id', '=', 'service_instance_dep.instance_dep_id');

                $query->where('target.environment_id', $request->environment_id);
                if (!empty($request->application_id)) {
                    $query->whereIn('target.application_id', $request->application_id);
                }
                if (!empty($request->hosting_id)) {
                    $query->whereIn('target.hosting_id', $request->hosting_id);
                }
            })
            ->where('instance_id', $serviceInstance->id);

        if (!empty($request->team_id)) {
            $depQuery->whereHas('serviceInstance.application', function (Builder $query) use ($request) {
                $query->whereIn('team_id', $request->team_id);
            });
        }

        return $depQuery->get();
    }
}
