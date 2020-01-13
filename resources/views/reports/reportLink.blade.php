{{ Route::currentRouteName() }}
<div class="card-header">
  <ul class="nav nav-tabs card-header-tabs">
    <li class="nav-item">
      <a class="nav-link @yield('status')" href="{{ route('reportPage',[1]) }}">Warehouses</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @yield('status')" href="{{ route('reportPage',[2]) }}">Goods</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @yield('status')" href="{{ route('reportPage',[3]) }}">Sales</a>
    </li>
    <li class="nav-item">
      <a class="nav-link @yield('status')" href="{{ route('reportPage',[4]) }}">Purchases</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Link</a>
    </li>
    <li class="nav-item">
      <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
    </li>
  </ul>
</div>
