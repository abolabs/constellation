<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateServiceVersionDependenciesAPIRequest;
use App\Http\Requests\API\UpdateServiceVersionDependenciesAPIRequest;
use App\Models\ServiceVersionDependencies;
use App\Repositories\ServiceVersionDependenciesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ServiceVersionDependenciesResource;
use Response;

/**
 * Class ServiceVersionDependenciesController
 * @package App\Http\Controllers\API
 */

class ServiceVersionDependenciesAPIController extends AppBaseController
{
    /** @var  ServiceVersionDependenciesRepository */
    private $serviceVersionDependenciesRepository;

    public function __construct(ServiceVersionDependenciesRepository $serviceVersionDependenciesRepo)
    {
        $this->serviceVersionDependenciesRepository = $serviceVersionDependenciesRepo;
    }

    /**
     * Display a listing of the ServiceVersionDependencies.
     * GET|HEAD /serviceVersionDependencies
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ServiceVersionDependenciesResource::collection($serviceVersionDependencies), 'Service Version Dependencies retrieved successfully');
    }

    /**
     * Store a newly created ServiceVersionDependencies in storage.
     * POST /serviceVersionDependencies
     *
     * @param CreateServiceVersionDependenciesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceVersionDependenciesAPIRequest $request)
    {
        $input = $request->all();

        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->create($input);

        return $this->sendResponse(new ServiceVersionDependenciesResource($serviceVersionDependencies), 'Service Version Dependencies saved successfully');
    }

    /**
     * Display the specified ServiceVersionDependencies.
     * GET|HEAD /serviceVersionDependencies/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ServiceVersionDependencies $serviceVersionDependencies */
        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->find($id);

        if (empty($serviceVersionDependencies)) {
            return $this->sendError('Service Version Dependencies not found');
        }

        return $this->sendResponse(new ServiceVersionDependenciesResource($serviceVersionDependencies), 'Service Version Dependencies retrieved successfully');
    }

    /**
     * Update the specified ServiceVersionDependencies in storage.
     * PUT/PATCH /serviceVersionDependencies/{id}
     *
     * @param int $id
     * @param UpdateServiceVersionDependenciesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceVersionDependenciesAPIRequest $request)
    {
        $input = $request->all();

        /** @var ServiceVersionDependencies $serviceVersionDependencies */
        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->find($id);

        if (empty($serviceVersionDependencies)) {
            return $this->sendError('Service Version Dependencies not found');
        }

        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->update($input, $id);

        return $this->sendResponse(new ServiceVersionDependenciesResource($serviceVersionDependencies), 'ServiceVersionDependencies updated successfully');
    }

    /**
     * Remove the specified ServiceVersionDependencies from storage.
     * DELETE /serviceVersionDependencies/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ServiceVersionDependencies $serviceVersionDependencies */
        $serviceVersionDependencies = $this->serviceVersionDependenciesRepository->find($id);

        if (empty($serviceVersionDependencies)) {
            return $this->sendError('Service Version Dependencies not found');
        }

        $serviceVersionDependencies->delete();

        return $this->sendSuccess('Service Version Dependencies deleted successfully');
    }
}
