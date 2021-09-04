<?php

namespace App\Http\Controllers;

use App\Http\Requests\Createhosting_typeRequest;
use App\Http\Requests\Updatehosting_typeRequest;
use App\Repositories\hosting_typeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class hosting_typeController extends AppBaseController
{
    /** @var  hosting_typeRepository */
    private $hostingTypeRepository;

    public function __construct(hosting_typeRepository $hostingTypeRepo)
    {
        $this->hostingTypeRepository = $hostingTypeRepo;
    }

    /**
     * Display a listing of the hosting_type.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $hostingTypes = $this->hostingTypeRepository->paginate(10);

        return view('hosting_types.index')
            ->with('hostingTypes', $hostingTypes);
    }

    /**
     * Show the form for creating a new hosting_type.
     *
     * @return Response
     */
    public function create()
    {
        return view('hosting_types.create');
    }

    /**
     * Store a newly created hosting_type in storage.
     *
     * @param Createhosting_typeRequest $request
     *
     * @return Response
     */
    public function store(Createhosting_typeRequest $request)
    {
        $input = $request->all();

        $hostingType = $this->hostingTypeRepository->create($input);

        Flash::success('Hosting Type saved successfully.');

        return redirect(route('hostingTypes.index'));
    }

    /**
     * Display the specified hosting_type.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        return view('hosting_types.show')->with('hostingType', $hostingType);
    }

    /**
     * Show the form for editing the specified hosting_type.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        return view('hosting_types.edit')->with('hostingType', $hostingType);
    }

    /**
     * Update the specified hosting_type in storage.
     *
     * @param int $id
     * @param Updatehosting_typeRequest $request
     *
     * @return Response
     */
    public function update($id, Updatehosting_typeRequest $request)
    {
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        $hostingType = $this->hostingTypeRepository->update($request->all(), $id);

        Flash::success('Hosting Type updated successfully.');

        return redirect(route('hostingTypes.index'));
    }

    /**
     * Remove the specified hosting_type from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $hostingType = $this->hostingTypeRepository->find($id);

        if (empty($hostingType)) {
            Flash::error('Hosting Type not found');

            return redirect(route('hostingTypes.index'));
        }

        $this->hostingTypeRepository->delete($id);

        Flash::success('Hosting Type deleted successfully.');

        return redirect(route('hostingTypes.index'));
    }
}
