<div class="card bg-none card-box">
{{Form::model($client,array('route' => array('client.password.update', $client->id), 'method' => 'post')) }}

<div class="row">
    <div class="form-group col-md-6">
        {{ Form::label('password', __('Password')) }}
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        @error('password')
        <span class="invalid-feedback" role="alert">
               <strong>{{ $message }}</strong>
           </span>
        @enderror
    </div>
    <div class="form-group col-md-6">
        {{ Form::label('password_confirmation', __('Confirm Password')) }}
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
    </div>
</div>
    <div class="col-md-12">
        <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
        <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
    </div>

{{ Form::close() }}
</div>
