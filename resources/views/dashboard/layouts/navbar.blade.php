<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header flex items-center py-4 px-6 h-header-height">
            <a href="{{ route('Admin.home') }}" class="b-brand flex items-center gap-3">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ asset('dashboard/assets/images/logo-white.svg') }}" class="img-fluid logo"
                    alt="logo" />
                <img src="{{ asset('dashboard/assets/images/favicon.svg') }}" class="img-fluid logo logo-sm"
                    alt="logo" />
            </a>
        </div>
        <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
            <ul class="pc-navbar">
                <li class="pc-item pc-caption">
                    <label>Dashboard</label>
                </li>
                <li class="pc-item">
                <li class="pc-item">
                    <a href="{{ route('Admin.home') }}" class="pc-link">
                        <span class="pc-micon">
                            <i data-feather="home"></i>
                        </span>
                        <span class="pc-mtext">{{ __('Dashboard') }}</span>
                    </a>
                </li>
                {{--  <li class="pc-item pc-caption">
                    <label>UI Components</label>
                    <i data-feather="feather"></i>
                </li>  --}}
                @can('roles-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.roles.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="shield"></i></span>
                            <span class="pc-mtext">Role</span>
                        </a>
                    </li>
                @endcan
                @can('admins-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.admins.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="user-check"></i></span>
                            <span class="pc-mtext">Admin</span>
                        </a>
                    </li>
                @endcan

                @can('users-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.users.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="users"></i></span>
                            <span class="pc-mtext">User</span>
                        </a>
                    </li>
                @endcan




                @can('send_notifications-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.send_notifications.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="send"></i></span>
                            <span class="pc-mtext">Send Notification</span>
                        </a>
                    </li>
                @endcan

                @can('cities-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.cities.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="map-pin"></i></span>
                            <span class="pc-mtext">City</span>
                        </a>
                    </li>
                @endcan

                @can('category_excursions-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.category_excursions.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="layers"></i></span>
                            <span class="pc-mtext">Category Excursions</span>
                        </a>
                    </li>
                @endcan
                 @can('sub_category_excursions-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.sub_category_excursions.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="layers"></i></span>
                            <span class="pc-mtext">Sub Category Excursions</span>
                        </a>
                    </li>
                @endcan

                @can('excursions-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.excursions.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="compass"></i></span>
                            <span class="pc-mtext">Excursion</span>
                        </a>
                    </li>
                @endcan

                @can('additional_services-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.additional_services.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="plus-circle"></i></span>
                            <span class="pc-mtext">Additional Service</span>
                        </a>
                    </li>
                @endcan

                {{--  @can('order_additional_services-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.order_additional_services.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="clipboard"></i></span>
                            <span class="pc-mtext">Order Additional Service</span>
                        </a>
                    </li>
                @endcan  --}}

                {{-- @can('category_events-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.category_events.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="tag"></i></span>
                            <span class="pc-mtext">Category Events</span>
                        </a>
                    </li>
                @endcan --}}

                @can('events-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.events.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="calendar"></i></span>
                            <span class="pc-mtext">Events</span>
                        </a>
                    </li>
                @endcan


                @can('category_real_estates-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.category_real_estates.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="layers"></i></span>
                            <span class="pc-mtext">Category Real Estates</span>
                        </a>
                    </li>
                @endcan

                @can('real_estates-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.real_estates.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="map-pin"></i></span>
                            <span class="pc-mtext">Real Estates</span>
                        </a>
                    </li>
                @endcan

                @can('offers-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.offers.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="tag"></i></span>
                            <span class="pc-mtext">Offers</span>
                        </a>
                    </li>
                @endcan

                @can('files-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.files.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="file"></i></span>
                            <span class="pc-mtext">Files</span>
                        </a>
                    </li>
                @endcan

                @can('hotels-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.hotels.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="map-pin"></i></span>
                            <span class="pc-mtext">Hotels</span>
                        </a>
                    </li>
                @endcan

                @can('orders-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.orders.index') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="send"></i></span>
                            <span class="pc-mtext">Reservation</span>
                        </a>
                    </li>
                @endcan


                @can('reports-index')
                    <li class="pc-item pc-hasmenu">
                        <a href="{{ route('Admin.reports') }}" class="pc-link">
                            <span class="pc-micon"><i data-feather="bar-chart-2"></i></span>
                            <span class="pc-mtext">Reports</span>
                        </a>
                    </li>
                @endcan







                {{--  <li class="pc-item pc-hasmenu">
          <a href="../elements/icon-feather.html" class="pc-link">
            <span class="pc-micon"> <i data-feather="feather"></i></span>
            <span class="pc-mtext">Icons</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Pages</label>
          <i data-feather="monitor"></i>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="../pages/login-v1.html" class="pc-link" target="_blank">
            <span class="pc-micon"> <i data-feather="lock"></i></span>
            <span class="pc-mtext">Login</span>
          </a>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="../pages/register-v1.html" class="pc-link" target="_blank">
            <span class="pc-micon"> <i data-feather="user-plus"></i></span>
            <span class="pc-mtext">Register</span>
          </a>
        </li>
        <li class="pc-item pc-caption">
          <label>Other</label>
          <i data-feather="sidebar"></i>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"> <i data-feather="align-right"></i> </span><span
              class="pc-mtext">Menu levels</span><span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
                  <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i class="ti ti-chevron-right"></i></span></a>
                  <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="pc-item">
          <a href="../other/sample-page.html" class="pc-link">
            <span class="pc-micon">
              <i data-feather="sidebar"></i>
            </span>
            <span class="pc-mtext">Sample page</span>
          </a>
        </li>  --}}
            </ul>
        </div>
    </div>
</nav>
