@extends('layouts.app', ['page' => __('Создать пользователя'), 'pageSlug' => 'create users'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if (session('successful'))
                <div class="alert alert-success">
                    {{ session('successful') }}
                </div>
            @endif
            @if ($errors->has('trx_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('trx_error') }}
                </div>
            @endif
            <div class="card-header">
                <h5 class="title">Создание Пользователя</h5>
            </div>
            <!-- add route -->
            <form method="post" action="{{ route('store.users') }}" autocomplete="off">
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
                            <input type="text" name="hash_id" class="form-control" value="{{ old('hash_id', $data['hash_id']) }}" style="pointer-events: none;">
                        </div>
                        @error('hash_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Пароль</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div>
                            <input type="text" name="password" class="form-control" placeholder="введите пароль" value="{{ old('password') }}" required>
                        </div>
                        @error('password')
                        <div class="text-danger">Пароль от 8 символов с учетом букв и цифр</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Выбрать роль пользователя</label>
                        <select class="form-control" id="role" name="role">
                            @if(Auth::user()->hasRole('admin'))
                            <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Клиент</option>
                            <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Куратор</option>
                            <option value="market" {{ old('role') == 'market' ? 'selected' : '' }}>Обменник</option>
                            <option value="support" {{ old('role') == 'support' ? 'selected' : '' }}>Поддержка</option>
                            @elseif(Auth::user()->hasRole('agent'))
                            <option value="market" {{ old('role') == 'market' ? 'selected' : '' }}>Обменник</option>
                            @endif
                        </select>
                    </div>
                    @error('role')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div id="unsupport">

                        <div class="form-group">
                            <label>Реквизиты получения</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-wallet-43"></i>
                                    </div>
                                </div>
                                <input type="text" name="details_to" class="form-control" placeholder="Введите реквизиты получения, начинающтеся на T..." value="{{ old('details_to') }}" >
                            </div>
                        </div>
                        @error('details_to')
                        <div class="text-danger">Реквезиты должны начинаться с Т... !</div>
                        @enderror

                        <div class="form-group">
                            <label>Процент</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="tim-icons icon-bank"></i>
                                    </div>
                                </div>
                                <input type="text" name="percent" class="form-control" placeholder="Введите процент для пользователя" value="{{ old('percent') }}" >
                            </div>
                        </div>
                        @error('percent')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="form-group" id="market">
                            <label>Выбор куратора для обменника</label>
                            <select class="form-control" name="agent_id">
                                @foreach($data['agents'] as $agent)
                                <option value="{{ $agent->hash_id }}" {{ old('agent_id') == $agent->hash_id ? 'selected' : '' }}>{{ $agent->hash_id }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('market')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-fill btn-primary">Создать</button>
                </div>
            </form>

        </div>
    </div>
</div>


<script src="{{ asset('js') }}/users/SelectAgentIndex.js"></script>

@endsection