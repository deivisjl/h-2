@extends('layouts.landing')

@section('content')
<div class="container">
     <div class="row">
        <div class="col-md-6 col-md-offset-3">
             <div class="panel panel-herbalife">
                <div class="panel-header text-center"><h3>Cambiar contraseña</h3></div>
                <div class="panel-body">
                    <form action="/cambiar-credencial" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="usuario" value="{{ $usuario->id }}">                  

                        <div class="form-group">
                            <label class="control-label">Contraseña</label>
                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        {{ $errors->first('password') }}
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Repetir contraseña</label>
                            <input type="password" name="password_confirmation" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}">
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Guardar</button>
                        </div>
                    </form>
                </div>
             </div>
        </div>
     </div>
</div>
@endsection


