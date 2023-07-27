<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link">
      <img src="{{ asset("assets/admin/img/AdminLTELogo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Панель управления</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset("assets/admin/img/admin.svg") }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('admin.index')}}" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item {{ request()->routeIs('admin.index') ? 'menu-open' : '' }}">
            <a href="{{ route('admin.index')}}" class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
            </a>
          </li>

          @if (auth()->user()->is_admin || auth()->user()->is_curator)
          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'semester' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.semester.list') }}" class="nav-link {{ explode('.', request()->route()->getName())[1] == 'semester' ? 'active' : '' }}">
              <i class="nav-icon fas fa-window-restore"></i>
              <p>
                Семестры
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.semester.list') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все семестры</p>
                </a>
              </li>

              @if (auth()->user()->is_admin)
                <li class="nav-item">
                  <a href="{{ route('admin.semester.create') }}" class="nav-link">
                    <i class="far fas fa-plus nav-icon"></i>
                    <p>Новый семестр</p>
                  </a>
                </li>
              @endif

            </ul>
          </li>
          @endif


          {{-- <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'criteria' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.criteria.list')}}" class="nav-link {{ explode('.', request()->route()->getName())[1] == 'criteria' ? 'active' : '' }}">
              <i class="nav-icon fas fa-window-restore"></i>
              <p>
                Критерии
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.criteria.list')}}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все критерии</p>
                </a>
              </li>

              @if (auth()->user()->is_admin)
              <li class="nav-item">
                <a href="{{ route('admin.criteria.create') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый критерий</p>
                </a>
              </li>
              @endif

            </ul>
          </li> --}}

          {{-- <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'table' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.table.list')}}" class="nav-link {{ explode('.', request()->route()->getName())[1] == 'table' ? 'active' : '' }}">
              <i class="nav-icon fas fa-window-restore"></i>
              <p>
                Таблицы
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.table.list')}}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все таблицы</p>
                </a>
              </li>

              @if (auth()->user()->is_admin)
              <li class="nav-item">
                <a href="{{ route('admin.table.create') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новая таблица</p>
                </a>
              </li>
              @endif

            </ul>
          </li> --}}

          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'curator' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.curator.list')}}" class="nav-link {{ explode('.', request()->route()->getName())[1] == 'curator' ? 'active' : '' }}">
              <i class="nav-icon fas fa-window-restore"></i>
              <p>
                Кураторы
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.curator.list')}}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все кураторы</p>
                </a>
              </li>
              @if (auth()->user()->is_admin)
              <li class="nav-item">
                <a href="{{ route('admin.curator.create') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый куратор</p>
                </a>
              </li>
              @endif

            </ul>
          </li>

          @if (auth()->user()->is_admin)
          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'document' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.document.list')}}" class="nav-link {{ explode('.', request()->route()->getName())[1] == 'document' ? 'active' : '' }}">
              <i class="nav-icon fas fa-window-restore"></i>
              <p>
                Документы
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.document.list')}}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все документы</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.document.create') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый документ</p>
                </a>
              </li>

            </ul>
          </li>
          @endif

          @if (auth()->user()->is_admin)
          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'user' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.user.list')}}" class="nav-link {{ explode('.', request()->route()->getName())[1] == 'user' ? 'active' : '' }}">
              <i class="nav-icon fas fa-window-restore"></i>
              <p>
                Пользователи
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.user.list')}}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все пользователи</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.user.create') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый пользователь</p>
                </a>
              </li>

            </ul>
          </li>
          @endif

          @if (auth()->user()->is_admin)
          <li class="nav-item {{ request()->routeIs('admin.settings.index') ? 'menu-open' : '' }}">
            <a href="{{ route('admin.settings.index')}}" class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Настройки</p>
            </a>
          </li>
          @endif
          

          {{-- <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'section' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.section.all')}}" class="nav-link {{ explode('.', request()->route()->getName())[1] == 'section' ? 'active' : '' }}">
              <i class="nav-icon fas fa-window-restore"></i>
              <p>
                Разделы
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.section.all')}}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все разделы</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.section.suball')}}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все подразделы</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.section.create.page') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый раздел</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{ route('admin.section.subcreate.page') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый подраздел</p>
                </a>
              </li>

            </ul>
          </li>
          

          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'posts' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.posts.all')}}" class="nav-link {{ explode('.', request()->route()->getName())[1] == 'posts' ? 'active' : '' }}">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Посты
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.posts.all') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все посты</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.posts.create') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый пост</p>
                </a>
              </li>
            </ul>
          </li>



          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'category' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.category.all') }}" class="nav-link {{ request()->routeIs('admin.category.all') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tags"></i>
              <p>
                Категории
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.category.all') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все категории</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.category.create.page') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новая категория</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'author' ? 'menu-open' : '' }} {{ explode('.', request()->route()->getName())[1] == 'consultant' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.author.all') }}" class="nav-link {{ request()->routeIs('admin.author.all') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Авторы/Консультанты
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.author.all') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все авторы</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.consultant.all') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все консультанты</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('admin.author.create.page') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый автор</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.consultant.create.page') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый консультант</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'user' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.user.all') }}" class="nav-link {{ request()->routeIs('admin.user.all') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Пользователи
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.user.all') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все пользователи</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.user.create.page') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый пользователь</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'subscriber' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.subscriber.all') }}" class="nav-link {{ request()->routeIs('admin.subscriber.all') ? 'active' : '' }}">
              <i class="nav-icon fas fa-paper-plane"></i>
              <p>
                Подписчики
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.subscriber.all') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все подписчики</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.subscriber.distribution') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все рассылки</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.subscriber.mail') }}" class="nav-link">
                  <i class="far fas fa-share nav-icon"></i>
                  <p>Новая рассылка</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'banner' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.banner.all') }}" class="nav-link {{ request()->routeIs('admin.banner.all') ? 'active' : '' }}">
              <i class="nav-icon far fa-image"></i>
              <p>
                Баннеры
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.banner.all') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все баннеры</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.banner.create.page') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый баннер</p>
                </a>
              </li>
            </ul>
          </li>


          <li class="nav-item">
            <a href="{{ route('admin.contact.all') }}" class="nav-link {{ request()->routeIs('admin.contact.all') ? 'active' : '' }}">
              <i class="nav-icon fas fa-comments"></i>
              <p>
                Вопросы
                @if (isset($questions_count))
                  <span class="badge badge-info right">{{ $questions_count }}</span>
                @endif
              </p>
            </a>
          </li>

          <li class="nav-item {{ explode('.', request()->route()->getName())[1] == 'faq' ? 'menu-open' : '' }}">
            <a href="{{ route('admin.faq.all') }}" class="nav-link {{ request()->routeIs('admin.faq.all') ? 'active' : '' }}">
              <i class="nav-icon fas fa-question-circle"></i>
              <p>
                FAQ
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.faq.all') }}" class="nav-link">
                  <i class="far fas fa-list nav-icon"></i>
                  <p>Все вопросы</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.faq.create.page') }}" class="nav-link">
                  <i class="far fas fa-plus nav-icon"></i>
                  <p>Новый вопрос</p>
                </a>
              </li>
            </ul>
          </li> --}}
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>