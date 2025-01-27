@extends('layouts.app', ['page' => __('Обновление данных об пользователе'), 'pageSlug' => 'update users'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Обновление данных об пользователе</h5>
            </div>
            <div class="card-footer">
                <button onclick="window.history.back()" class="btn btn-primary btn-round">Назад</button>
            </div>
            <form method="post" action="{{route('table.user.update', ['hash_id'=>$hash_id])}}" autocomplete="off">
                @method('PUT')
                @csrf
                <div class="card-body">
                    
                        <div class="form-group">
                            <label>Hash ID</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                    <i class="tim-icons icon-single-02"></i>
                                </div>          
                            </div>
                            <input type="text" name="hash_id" class="form-control" value="{{$hash_id}}" style="pointer-events: none;">
                        </div>

                        <div class="form-group">
                            <label>Реквезиты пополнения</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-money-coins"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_from" class="form-control" value="{{$user->details_from}}">
                            </div>
                        </div>
                        @error('details_from')
                            <div class="text-danger">Кошелек должен начинаться с буквы Т</div>
                        @enderror

                        <div class="form-group">
                            <label>Приватный ключ реквезитов пополнения </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-key-25"></i>
                                    </div>          
                                </div>
                                <input type="text" name="private_key" class="form-control" value="{{$user->private_key}}">
                            </div>
                        </div>
                        @error('private_key')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group">
                            <label>Реквезиты вывода </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-wallet-43"></i>
                                    </div>          
                                </div>
                                <input type="text" name="details_to" class="form-control" value="{{$user->details_to}}">
                            </div>
                        </div>
                        @error('details_to')
                            <div class="text-danger">Кошелек должен начинаться с буквы Т</div>
                        @enderror                        

                        <div class="form-group">
                            <label>Баланс</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-coins"></i>
                                    </div>          
                                </div>
                                <input type="text" name="balance" class="form-control" value="{{$user->balance}}" style="pointer-events: none;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Процент</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="tim-icons icon-bank"></i>
                                    </div>          
                                </div>
                                <input type="text" name="percent" class="form-control" value="{{$user->percent}}">
                            </div>
                        </div>
                        @error('percent')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror



                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Обновить</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection