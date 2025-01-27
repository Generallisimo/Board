@extends('layouts.app', ['page' => __('Отправка TRX'), 'pageSlug' => 'send_trx'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif
            <div class="card-header">
                <h5 class="title">Отправка TRX</h5>
            </div>
            <form method="post" action="{{route('send.store')}}" autocomplete="off">
                @csrf
                <div class="card-body">
                    
                    
                        <div class="form-group">
                            <label>Выбор пользователя</label>
                            <select class="form-control" name="user_id">
                                @foreach($users as $user)
                                <option value="{{ $user->hash_id }}" {{ old('user_id') == $user->hash_id ? 'selected' : '' }}>{{ $user->hash_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('user_id')
                        <div class="text-danger">Обратитесь в тех поддержку</div>
                        @enderror
                        
                        
                        <div class="form-group">
                            <label>Процент</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-bank"></i>
                                    </div>
                                </div>
                                <input type="text" name="amount" class="form-control" placeholder="Введите сумму в TRX" >
                            </div>
                        </div>
                        @error('amount')
                        <div class="text-danger">Обратитесь в тех поддержку</div>
                        @enderror
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">Отправить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection