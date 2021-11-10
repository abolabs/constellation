<div class="d-flex">
    {!! Form::open(['route' => [$basePath.'.destroy', $id], 'method' => 'delete']) !!}
    <div class="btn-group">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-cog"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
          <a class="dropdown-item" href="{{ route($basePath.'.show', $id) }}">Voir</a>
          <a class="dropdown-item" href="{{ route($basePath.'.edit', $id) }}">Editer</a>
          {!! Form::button('Supprimer', [
            'type' => 'submit',
            'class' => 'dropdown-item',
            'onclick' => "return confirm('Are you sure?')"
        ]) !!}

        </div>
      </div>
    {!! Form::close() !!}
</div>
