{{ Form::hidden('user_id', auth()->User()->id) }}

<div class="form-group">
    {{ Form::label('category_id', 'Nombre de la Categoria') }}
    {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::label('name', 'Nombre de la etiqueta') }}
    {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
</div>

<div class="form-group">
    {{ Form::label('slug', 'URL Amigable') }}
    {{ Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug']) }}
</div>

<div class="form-group">
    {{ Form::label('file', 'Imagen') }}
    {{ Form::file('file') }}
</div>

<div class="form-group">
    {{ Form::label('status', 'Estado') }}
    <label>
    {{ Form::radio('status', 'PUBLISHED') }} Publicado   
    </label>
    <label>
    {{ Form::radio('status', 'DRAFT') }} Borrador   
    </label>
</div>

<div class="form-group">
    {{ Form::label('tags', 'Etiquetas') }}
    <div>
        @foreach($tags as $tag)
        <label>
        <!-- pregunta para invetigar: porque se debe cerrar y abrir el helper si todo el codigo es php -->
            {{ Form::checkbox('tags[]', $tag->id) }} {{ $tag->name }} 
        
        </label>
        @endforeach
    </div>
</div>

<div class="form-group">
    {{ Form::label('excerpt', 'Extracto') }}
    {{ Form::textarea('excerpt', null, ['class' => 'form-control', 'rows' => '2']) }}
</div>

<div class="form-group">
    {{ Form::label('body', 'Descripcion') }}
    {{ Form::textarea('body', null, ['class' => 'form-control']) }}
</div>

<div class="form-group">
    {{ Form::submit('Guardar', ['class' => 'btn btn-sm btn-primary']) }}
</div>

@section('scripts')
<script src="{{ asset('vendor/jqueryToSlug/jquery.stringToSlug.min.js') }}"></script>
<script src="{{ asset('vendor/editor/ckeditor.js') }}"></script>

<script>
    $(document).ready(function(){
        // $("#slug").val("La URL se genera automaticamente llenando el campo Nombre");
        $("#slug, #name").stringToSlug({
            callback: function(text){
                $("#slug").val(text);
            }
        });
    });

    // CKEDITOR.config.height = 400;
    CKEDITOR.config.width = 'auto';
    

    CKEDITOR.replace('body');
</script>
@endsection