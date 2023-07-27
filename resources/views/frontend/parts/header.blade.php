<header class="header">
    <div class="container">
        <div class="header__wrap">
            <div class="header-logo">Личный Кабинет</div>
            <nav class="header-nav">
                <a href="{{ route('lk.index') }}" class="header-nav__link {{ request()->routeIs('lk.index') ? 'active' : '' }}">Главная</a>
                <a href="{{ route('lk.documents') }}" class="header-nav__link {{ request()->routeIs('lk.documents') ? 'active' : '' }}">Документы</a>
                @if (auth()->user()->is_admin)
                    <a href="{{ route('admin.index') }}" class="header-nav__link ">Админка</a>
                @endif

                @if (!auth()->user()->is_admin && auth()->user()->is_curator)
                    <a href="{{ route('admin.index') }}" class="header-nav__link ">Панель куратора</a>
                @endif
            </nav>
            <div class="header-menu">
                <span>{{ auth()->user()->name }}</span>
                <div class="header-dropdown">
                    <a href="#" class="header-dropdown__link">Настройки</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="header-dropdown__link">Выход</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
