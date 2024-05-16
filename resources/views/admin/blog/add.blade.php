@extends('layouts.admin')
@section('metatag')
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
@endsection
@section('content')
    <form action="{{ url('blog/') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-dark">Agregar Nuevo Blog</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">                            
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static mb-4">
                                    <label>Título</label>
                                    <input required type="text" class="form-control form-control-lg" name="title">
                                </div>
                            </div>  
                            <div class="col-md-6 mb-3">
                                <div class="input-group input-group-static mb-4">
                                    <label>Nombre URL (Este nombre se mostrará en la url del blog)</label>
                                    <input required type="text" class="form-control form-control-lg" name="name_url">
                                </div>
                            </div>  
                            <div class="col-md-12 mb-3">
                                <label>Imagen</label>
                                <div class="input-group input-group-lg input-group-outline my-3">
                                    <input required class="form-control" type="file" name="image">
                                </div>
                            </div>                        
                  
                            
                            <div class="col-md-12 mb-3">
                                <div class="input-group input-group-static mb-4">
                                    <textarea id="editor" type="text" class="form-control form-control-lg" name="body"
                                        placeholder="Descripción del blog"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <button type="submit" class="btn btn-velvet">Agregar blog</button>
                        </div>
                    </div>
                </div>
            </div>          
        </div>
    </form>

    <center>
        <div class="col-md-12 mt-3">
            <a href="{{ url('blog/indexadmin') }}" class="btn btn-velvet w-25">Volver</a>
        </div>
    </center>
@endsection
@section('script')
    <script>
        $(document).ready(function() {         
            ClassicEditor
                .create(document.querySelector('#editor'), {                    
                    heading: {
                        options: [{
                                model: 'paragraph',
                                title: 'Párrafo',
                                class: 'ck-heading_paragraph'
                            },
                            {
                                model: 'heading1',
                                view: 'h1',
                                title: 'Título',
                                class: 'ck-heading_heading1'
                            }                            
                        ]
                    }                    
                })
                .catch(error => {
                    console.log(error);
                });
        });
    </script>
@endsection