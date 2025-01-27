@extends('layouts.app', ['page' => __('Добавить реквезиты'), 'pageSlug' => 'add details'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if (session('successful'))
                <div class="alert alert-success">
                    {{ session('successful') }}
                </div>
            @endif
            @if ($errors->has('details_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('details_error') }}
                </div>
            @endif
            <div class="card-header">
                <h5 class="title">Добавить новые реквезиты обменникам</h5>
            </div>
            <form method="post" action="{{route('store.details')}}" autocomplete="off">
                @csrf
                <div class="card-body">
                    

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выбор обменника</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="hash_id">        
                            @foreach($data['markets'] as $market)
                                <option value="{{$market->hash_id}}" {{ old('hash_id') == $market->hash_id ? 'selected' : '' }}>{{$market->hash_id}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('hash_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Выбор метода оплаты</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="name_method">        
                            @foreach($data['methods'] as $method)
                                <option value="{{$method->name_method}}" {{ old('name_method') == $method->name_method ? 'selected' : '' }}>{{$method->name_method}} {{$method->currency}}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('name_method')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    
                    <div class="form-group">
                        <label>Реквезиты пополнения</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-wallet-43"></i>
                                </div>          
                            </div>
                            <input type="text" name="details_market_to" class="form-control" placeholder="введите реквезиты пополнения" value="{{ old('details_market_to') }}">
                        </div>
                    </div>
                    @error('details_market_to')
                        <div class="text-danger">Нужно ввести либо номер телефона, либо номер карты. Также повторять реквезиты нельзя!</div>
                    @enderror

                    <div class="form-group">
                        <label>Комментарий обменника для перевода</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-pencil"></i>
                                </div>          
                            </div>
                            <input type="text" name="comment" class="form-control" placeholder="введите комментарий" value="{{ old('comment') }}">
                        </div>
                    </div>
                    @error('comment')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror   
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Создать</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection