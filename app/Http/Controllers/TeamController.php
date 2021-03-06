<?php

namespace App\Http\Controllers;

use App\DataTables\TeamDataTable;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Repositories\TeamRepository;
use Flash;
use Response;

class TeamController extends AppBaseController
{
    /** @var TeamRepository */
    private $teamRepository;

    public function __construct(TeamRepository $teamRepo)
    {
        $this->authorizeResource(Team::class);
        $this->teamRepository = $teamRepo;
    }

    /**
     * Display a listing of the Team.
     *
     * @param  TeamDataTable  $teamDataTable
     * @return Response
     */
    public function index(TeamDataTable $teamDataTable)
    {
        return $teamDataTable->render('teams.index');
    }

    /**
     * Show the form for creating a new Team.
     *
     * @return Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created Team in storage.
     *
     * @param  CreateTeamRequest  $request
     * @return Response
     */
    public function store(CreateTeamRequest $request)
    {
        $input = $request->all();

        $this->teamRepository->create($input);

        Flash::success('Team saved successfully.');

        return redirect(route('teams.index'));
    }

    /**
     * Display the specified Team.
     *
     * @param  Team  $team
     * @return Response
     */
    public function show(Team $team)
    {
        if (empty($team)) {
            Flash::error('Team not found');

            return redirect(route('teams.index'));
        }

        return view('teams.show')->with('team', $team);
    }

    /**
     * Show the form for editing the specified Team.
     *
     * @param  Team  $team
     * @return Response
     */
    public function edit(Team $team)
    {
        if (empty($team)) {
            Flash::error('Team not found');

            return redirect(route('teams.index'));
        }

        return view('teams.edit')->with('team', $team);
    }

    /**
     * Update the specified Team in storage.
     *
     * @param  Team  $team
     * @param  UpdateTeamRequest  $request
     * @return Response
     */
    public function update(Team $team, UpdateTeamRequest $request)
    {
        if (empty($team)) {
            Flash::error('Team not found');

            return redirect(route('teams.index'));
        }

        $team = $this->teamRepository->update($request->all(), $team->id);

        Flash::success('Team updated successfully.');

        return redirect(route('teams.index'));
    }

    /**
     * Remove the specified Team from storage.
     *
     * @param  Team  $team
     * @return Response
     */
    public function destroy(Team $team)
    {
        if (empty($team)) {
            Flash::error('Team not found');

            return redirect(route('teams.index'));
        }

        $this->teamRepository->delete($team->id);

        Flash::success('Team deleted successfully.');

        return redirect(route('teams.index'));
    }
}
