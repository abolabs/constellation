<div class="d-flex">
    <ul class="nav nav-pills">
        <li class="nav-item dropdown active">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i></a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route($basePath.'.show', $id) }}">{{ __('datatable.view')}}</a>
                @can("edit ".$permissionPrefix)
                <a class="dropdown-item" href="{{ route($basePath.'.edit', $id) }}">{{ __('datatable.edit')}}</a>
                @endcan
                @can("delete ".$permissionPrefix)
                {!! Form::open(['route' => [$basePath.'.destroy', $id], 'method' => 'delete']) !!}
                {!! Form::button(\Lang::get('datatable.delete'), [
                    'type' => 'submit',
                    'class' => 'dropdown-item',
                    'onclick' => "return confirm('".\Lang::get('datatable.confirm_delete')."')"
                ]) !!}
                {!! Form::close() !!}
                @endcan
            </div>
        </li>
    </ul>
</div>
