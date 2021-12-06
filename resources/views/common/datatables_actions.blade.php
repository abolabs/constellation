<div class="d-flex">
    {!! Form::open(['route' => [$basePath.'.destroy', $id], 'method' => 'delete']) !!}
    <div class="btn-group">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cog"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
          <a class="dropdown-item" href="{{ route($basePath.'.show', $id) }}">{{ __('datatable.view')}}</a>
          <a class="dropdown-item" href="{{ route($basePath.'.edit', $id) }}">{{ __('datatable.edit')}}</a>
          {!! Form::button(\Lang::get('datatable.delete'), [
            'type' => 'submit',
            'class' => 'dropdown-item',
            'onclick' => "return confirm('".\Lang::get('datatable.confirm_delete')."')"
        ]) !!}

        </div>
      </div>
    {!! Form::close() !!}
</div>
