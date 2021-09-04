<div class="table-responsive-sm">
    <table class="table table-striped" id="hostingTypes-table">
        <thead>
            <tr>
                <th>Name</th>
        <th>Description</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($hostingTypes as $hostingType)
            <tr>
                <td>{{ $hostingType->name }}</td>
            <td>{{ $hostingType->description }}</td>
                <td>
                    {!! Form::open(['route' => ['hostingTypes.destroy', $hostingType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('hostingTypes.show', [$hostingType->id]) }}" class='btn btn-ghost-success'><i class="fa fa-eye"></i></a>
                        <a href="{{ route('hostingTypes.edit', [$hostingType->id]) }}" class='btn btn-ghost-info'><i class="fa fa-edit"></i></a>
                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-ghost-danger', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>