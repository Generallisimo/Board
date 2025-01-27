@extends('layouts.app', ['page' => __('Изменить кошелек'), 'pageSlug' => 'update details'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
            @endif
            <div class="card-footer">
                <a href="{{route('home')}}" class="btn btn-primary btn-round">Назад</a>
            </div>
            <div class="card-header">
                <h5 class="title">Изменить кошелек</h5>
            </div>
            <form method="post" action="{{ route('home.wallet.update') }}" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="card-body">

                    <input type="text" name="hash_id" class="form-control" value="{{$data['user']->hash_id}}" hidden>

                    <div class="form-group">
                        <label>Реквезиты вывода</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-wallet-43"></i>
                                </div>
                            </div>
                            <input type="text" name="details_to" class="form-control" value="{{$data['user']->details_to}}">
                        </div>
                        @error('details_to')
                        <div class="text-danger">Реквезиты должны начинаться с Т... !</div>
                        @enderror
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Изменить</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script src="{{ asset('js') }}/users/SelectAgentIndex.js"></script>

@endsection