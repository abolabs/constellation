<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', \Lang::get('environnement.id')) !!}
    <p>{{ $environnement->id }}</p>
</div>
<hr class="my-2">

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', \Lang::get('environnement.name')) !!}
    <p>{{ $environnement->name }}</p>
</div>
<hr class="my-2">

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', \Lang::get('environnement.created_at')) !!}
    <p>{{ $environnement->created_at }}</p>
</div>
<hr class="my-2">

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', \Lang::get('environnement.update_at')) !!}
    <p>{{ $environnement->updated_at }}</p>
</div>

