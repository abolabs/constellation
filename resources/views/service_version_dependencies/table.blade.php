<div class="table-responsive-sm">
    <table class="table table-striped" id="serviceVersionDependencies-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Service Version Id</th>
        <th>Service Version Dependency Id</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($serviceVersionDependencies as $serviceVersionDependencies)
            <tr>
                <td>{{ $serviceVersionDependencies->id }}</td>
            <td>{{ $serviceVersionDependencies->service_version_id }}</td>
            <td>{{ $serviceVersionDependencies->service_version_dependency_id }}</td>
                <td>
                    {!! Form::open(['route' => ['serviceVersionDependencies.destroy', $serviceVersionDependencies->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('serviceVersionDependencies.show', [$serviceVersionDependencies->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('serviceVersionDependencies.edit', [$serviceVersionDependencies->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>