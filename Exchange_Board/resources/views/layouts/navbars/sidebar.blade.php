<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('BD') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Black Dashboard') }}</a>
        </div>
        <ul class="nav">
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('client') || Auth::user()->hasRole('market') ||  Auth::user()->hasRole('agent'))
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('market') ||  Auth::user()->hasRole('agent'))
            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="tim-icons icon-settings" ></i>
                    <span class="nav-link-text" >{{ __('Дополнительно') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                <div class="collapse show" id="laravel-examples">
                    <ul class="nav pl-4">
                        @if(Auth::user()->hasRole('admin') ||  Auth::user()->hasRole('agent'))
                        <li @if ($pageSlug == 'create users') class="active " @endif>
                            <a href="{{ route('create.users') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Создать пользователя') }}</p>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('market') ||  Auth::user()->hasRole('agent'))
                        <li @if ($pageSlug == 'add details') class="active " @endif>
                            <a href="{{ route('create.details') }}">
                                <i class="tim-icons icon-wallet-43"></i>
                                <p>{{ __('Добавить реквезиты') }}</p>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('agent'))
                        <li @if ($pageSlug == 'all users') class="active " @endif>
                            <a href="{{ route('table.users.index') }}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Все пользователи') }}</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('market') ||  Auth::user()->hasRole('agent') || Auth::user()->hasRole('support' ))
            <li @if ($pageSlug == 'market board') class="active " @endif>
                <a href="{{ route('transaction.index')  }}">
                    <i class="tim-icons icon-components"></i>
                    <p>{{ __('Транзакции') }}</p>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasRole('admin'))
            <li @if ($pageSlug == 'send_trx') class="active " @endif>
                <a href="{{ route('send.index')  }}">
                    <i class="tim-icons icon-send"></i>
                    <p>{{ __('Отправка TRX') }}</p>
                </a>
            </li>
            <li @if ($pageSlug == 'send') class="active " @endif>
                <a href="{{ route('money.index')  }}">
                    <i class="tim-icons icon-single-copy-04"></i>
                    <p>{{ __('Переводы') }}</p>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('market'))
            <li @if ($pageSlug == 'top up') class="active " @endif>
                <a href="{{ route('top_up.index')  }}">
                    <i class="tim-icons icon-money-coins"></i>
                    <p>{{ __('Пополнение') }}</p>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('market') ||  Auth::user()->hasRole('agent') || Auth::user()->hasRole('client'))
            <li @if ($pageSlug == 'withdrawal') class="active " @endif>
                <a href="{{ route('withdrawal.index')  }}">
                    <i class="tim-icons icon-coins"></i>
                    <p>{{ __('Вывод') }}</p>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('support'))
            <li @if ($pageSlug == 'support') class="active " @endif>
                <a href="{{ route('support.index')  }}">
                    <i class="tim-icons icon-chat-33"></i>
                    <p>{{ __('Поддержка') }}</p>
                </a>
            </li>
            @endif



            <!-- <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="{{ route('pages.icons') }}">
                    <i class="tim-icons icon-atom"></i>
                    <p>{{ __('Icons') }}</p>
                </a>
            </li> -->
        </ul>
    </div>
</div>
