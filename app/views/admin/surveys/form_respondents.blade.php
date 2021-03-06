@extends('admin.layout.master')
@section('content')

<link rel="stylesheet" href="{{asset('css/jsDatePick_ltr.min.css')}}">

@section('scripts')
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jsDatePick.min.1.3.js')}}"></script>
    <script type="text/javascript">

        window.onload = function() {
            new JsDatePick({
                useMode: 2,
                target: "birth_date",
                dateFormat: "%Y/%m/%d"
            });
        };
        
        function cancel () {
            window.location.href="{{ URL::to('admin/surveys/'.$id_questionary) }}";
        }

        jQuery(document).ready(function($) {
            $('#main-form').submit(function(){
                return validateForm();
            });

            $('form').bind("keyup keypress", function(e) {
                var code = e.keyCode || e.which; 
                if (code  == 13) {               
                    e.preventDefault();
                    return false;
                }
            });

            $('#identity_document').keyup(function(e){
                var code = e.keyCode || e.which; 
                if (code  == 13) {
                    e.preventDefault();

                    $.post('{{url('/admin/surveys/get-respondent-identity')}}', { identity_document: $(this).val() }, function(data){

                        $('#name').val(data.name);
                        $('#pattern_name').val(data.pattern_name);
                        $('#mattern_name').val(data.mattern_name);

                        if(data.sex == 'M') {
                            $('#masculino').prop('checked', true);
                        } else {
                            $('#femenino').prop('checked', true);                            
                        }

                        $('#phone').val(data.phone);
                        $('#street').val(data.street);
                        $('#exterior_number').val(data.exterior_number);
                        $('#interior_number').val(data.interior_number);

                    });

                    return false;
                }

                
            });
        });

    </script>
@endsection

    {{Form::open( array('url' => '/admin/surveys/'.$action, 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'main-form' ) )}}
    {{Form::hidden('id', $id_questionary)}}
    <fieldset>
        <legend>Nueva Encuesta</legend>

        <div class="form-group {{($errors->has('cologne') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Documento de Identidad</label>
            <div class="col-sm-6">
                {{Form::text('identity_document', $value = null, array('id' => 'identity_document', 'class' => 'form-control', 'maxlength' => 10, 'pattern' => '[0-9]+', 'title' => 'Solo números' ))}}
                @if($errors->has('identity_document'))
                    <span class="help-block">{{$errors->first('identity_document')}}</span>
                @endif
            </div>
        </div>

        <div class="form-group {{($errors->has('name') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Nombre</label>
            <div class="col-sm-6">
                {{Form::text('name', $value = null, array('id' => 'name', 'class' => 'form-control validate-input') )}}
                @if($errors->has('name'))
                    <span class="help-block">{{$errors->first('name')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('patern_name') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Apellido Paterno</label>
            <div class="col-sm-6">
                {{Form::text('patern_name', $value = null, array('id' => 'pattern_name', 'class' => 'form-control validate-input') )}}
                @if($errors->has('patern_name'))
                    <span class="help-block">{{$errors->first('patern_name')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('matern_name') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Apellido Materno</label>
            <div class="col-sm-6">
                {{Form::text('matern_name', $value = null, array('id' => 'matern_name', 'class' => 'form-control') )}}
                @if($errors->has('matern_name'))
                    <span class="help-block">{{$errors->first('matern_name')}}</span>
                @endif
            </div>
        </div>
        
        <!--
        <div class="form-group {{($errors->has('birth_date') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Fecha de Nacimiento</label>
            <div class="col-sm-6">
                <input type="text" size="48" id="birth_date" name="birth_date" onclick="" class="form-control" />
                @if($errors->has('birth_date'))
                    <span class="help-block">{{$errors->first('birth_date')}}</span>
                @endif
            </div>
        </div>
    -->
        
        <div class="form-group {{($errors->has('sex') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Sexo</label>
            <div class="col-sm-6">
                <input type="radio" name="sex" id="masculino" value="Masculino">&nbsp;Masculino
                &nbsp;&nbsp;&nbsp;
                <input type="radio" name="sex" id="femenino" value="Femenino">&nbsp;Femenino
            </div>
        </div>
        
        <div class="form-group {{($errors->has('phone') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Tel&eacute;fono</label>
            <div class="col-sm-6">
                {{Form::text('phone', $value = null, array('id' => 'phone', 'class' => 'form-control', 'maxlength' => '8', 'pattern' => '[0-9]+', 'title' => 'Sólo se aceptan números') )}}
                @if($errors->has('phone'))
                    <span class="help-block">{{$errors->first('phone')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('cellphone') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Celular</label>
            <div class="col-sm-6">
                {{Form::text('cellphone', $value = null, array('class' => 'form-control', 'maxlength' => '8', 'pattern' => '[0-9]+', 'title' => 'Sólo se aceptan números') )}}
                @if($errors->has('cellphone'))
                    <span class="help-block">{{$errors->first('cellphone')}}</span>
                @endif
            </div>
        </div>

        <div class="form-group {{($errors->has('cologne') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Calle</label>
            <div class="col-sm-6">
                {{Form::text('street', $value = null, array('id' => 'street', 'class' => 'form-control validate-input') )}}
                @if($errors->has('street'))
                    <span class="help-block">{{$errors->first('street')}}</span>
                @endif
            </div>
        </div>

        <div class="form-group {{($errors->has('exterior_number') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Casa/Apartamento</label>
            <div class="col-sm-6">
                {{Form::text('exterior_number', $value = null, array('id' => 'exterior_number', 'class' => 'form-control') )}}
                @if($errors->has('exterior_number'))
                    <span class="help-block">{{$errors->first('exterior_number')}}</span>
                @endif
            </div>
        </div>

        <!-- <div class="form-group {{($errors->has('interior_number') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Número interior</label>
            <div class="col-sm-6">
                {{Form::text('interior_number', $value = null, array('id' => 'interior_number', 'class' => 'form-control') )}}
                @if($errors->has('interior_number'))
                    <span class="help-block">{{$errors->first('interior_number')}}</span>
                @endif
            </div>
        </div> -->

        <div class="form-group {{($errors->has('location_reference') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Referencia de ubicación</label>
            <div class="col-sm-6">
                {{Form::text('location_reference', $value = null, array('class' => 'form-control validate-input') )}}
                @if($errors->has('location_reference'))
                    <span class="help-block">{{$errors->first('location_reference')}}</span>
                @endif
            </div>
        </div>
        
        <!-- <div class="form-group {{($errors->has('state') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Provincia</label>
            <div class="col-sm-6">
                {{Form::text('state', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('state'))
                    <span class="help-block">{{$errors->first('state')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('district') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Distrito</label>
            <div class="col-sm-6">
                {{Form::text('district', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('district'))
                    <span class="help-block">{{$errors->first('district')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('township') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Corregimiento</label>
            <div class="col-sm-6">
                {{Form::text('township', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('township'))
                    <span class="help-block">{{$errors->first('township')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('section') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Secci&oacute;n</label>
            <div class="col-sm-6">
                {{Form::text('section', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('section'))
                    <span class="help-block">{{$errors->first('section')}}</span>
                @endif
            </div>
        </div>
        
        <div class="form-group {{($errors->has('cologne') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">Colonia</label>
            <div class="col-sm-6">
                {{Form::text('cologne', $value = null, array('class' => 'form-control') )}}
                @if($errors->has('cologne'))
                    <span class="help-block">{{$errors->first('cologne')}}</span>
                @endif
            </div>
        </div> -->

        <div class="form-group {{($errors->has('cologne') ? 'has-error' : '')}} ">
            <label for="" class="col-sm-2 control-label">El Encuestado es</label>
            <div class="col-sm-6">
                <select name="type" id="type" class="form-control">
                    <option value="1">Jefe de Familia</option>
                    <option value="2">Cónyugue del jefe de familia</option>
                    <option value="3">Miembro de la familia</option>
                </select>
            </div>
        </div>
        
        {{Form::submit('Guardar', array('class' => 'btn btn-success'))}}
        
    </fieldset>
    {{Form::close()}}

@endsection