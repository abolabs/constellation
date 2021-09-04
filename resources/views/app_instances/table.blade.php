<div class="table-responsive-sm">
    <table class="table table-striped" id="appInstances-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Application Id</th>
        <th>Service Version Id</th>
        <th>Environnement Id</th>
        <th>Url</th>
        <th>Statut</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($appInstances as $appInstance)
            <tr>
                <td>{{ $appInstance->id }}</td>
            <td>{{ $appInstance->application_id }}</td>
            <td>{{ $appInstance->service_version_id }}</td>
            <td>{{ $appInstance->environnement_id }}</td>
            <td>{{ $appInstance->url }}</td>
            <td>{{ $appInstance->statut }}</td>
                <td>
                    {!! Form::open(['route' => ['appInstances.destroy', $appInstance->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('appInstances.show', [$appInstance->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('appInstances.edit', [$appInstance->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>