<!DOCTYPE html>
<html lang="en" style="height: auto;">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title','Skripsi')</title>
    <style media="print">
    .main-footer{
      display: none;
    }
    </style>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> -->
  </head>
  <body class="sidebar-mini" style="height: auto;">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ url('/') }}" class="nav-link">Home</a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ url('/') }}" class="brand-link">
        <img src="{{ asset('logo.svg') }}" alt="Skripsi Logo" class="brand-image">
        <span class="brand-text font-weight-light">Guna Elektro</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('user.svg') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <!-- <a href="#" class="d-block">{{ ucwords(Auth::user()->name) }}</a> -->
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">{{ ucwords(Auth::user()->name) }}</a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a class="nav-link btn btn-outline-warning" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
             <li class="nav-item">
               <a href="{{ url('/') }}" class="nav-link @hasSection('home') @yield('home') @endif">
                 <i class="nav-icon fas fa-th"></i>
                 <p>Home</p>
               </a>
             </li>
             @can('viewAny',App\Project::class)
             <li class="nav-item">
               <a href="{{ route('projects.index') }}" class="nav-link @hasSection('project') active @endif">
                 <i class="fas fa-comments-dollar nav-icon"></i>
                 <p>Projects</p>
               </a>
             </li>
             @endcan
            <li class="nav-item has-treeview @hasSection('order') menu-open @endif">
              <a href="#" class="nav-link @hasSection('order') active @endif">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>
                  Orders
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @can('viewAny',App\Sale::class)
                <li class="nav-item">
                  <a href="{{ route('sales.index') }}" class="nav-link @hasSection('sale') active @endif">
                    <i class="fas fa-comments-dollar nav-icon"></i>
                    <p>Sale</p>
                  </a>
                </li>
                @endcan
                @can('viewAny',App\Purchase::class)
                <li class="nav-item">
                  <a href="{{ route('purchases.index') }}" class="nav-link @hasSection('purchase') active @endif">
                    <i class="fas fa-shopping-cart nav-icon"></i>
                    <p>Purchase</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            <li class="nav-item has-treeview @hasSection('products') menu-open @endif">
              <a href="#" class="nav-link @hasSection('products') active @endif">
                <i class="nav-icon fas fa-warehouse @hasSection('products') active @endif"></i>
                <p>
                  Products
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @can('viewAny',App\Catalog::class)
                <li class="nav-item">
                  <a href="{{ route('catalogs.index') }}" class="nav-link @hasSection('catalogs') active @endif">
                    <i class="fas fa-clipboard-list nav-icon"></i>
                    <p>Catalogs</p>
                  </a>
                </li>
                @endcan
                @can('viewAny',App\Good::class)
                <li class="nav-item">
                  <a href="{{ route('goods.index') }}" class="nav-link @hasSection('goods') active @endif">
                    <i class="fas fa-boxes nav-icon"></i>
                    <p>Goods</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @can('viewAny',App\Unit::class)
            <li class="nav-item">
              <a href="{{ route('units.index') }}" class="nav-link @hasSection('units') active @endif">
                <i class="nav-icon fas fa-ruler"></i>
                <p>Units</p>
              </a>
            </li>
            @endcan
            @can('viewAny',App\Company::class)
            <li class="nav-item">
              <a href="{{ route('companies.index') }}" class="nav-link @hasSection('companies') active @endif">
                <i class="nav-icon fas fa-building"></i>
                <p>Companies</p>
              </a>
            </li>
            @endcan
            @can('viewAny',App\Checklist::class)
            <li class="nav-item">
              <a href="{{ route('checklists.index') }}" class="nav-link @hasSection('checklist') active @endif">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>Checklist</p>
              </a>
            </li>
            @endcan
            @can('viewAny',App\Surveyor::class)
            <li class="nav-item">
              <a href="{{ route('surveyors.index') }}" class="nav-link @hasSection('surveyors') active @endif">
                <i class="nav-icon fas fa-hard-hat"></i>
                <p>Surveyor</p>
              </a>
            </li>
            @endcan
            @can('viewAny',App\Designer::class)
            <li class="nav-item">
              <a href="{{ route('designers.index') }}" class="nav-link @hasSection('designers') active @endif">
                <i class="nav-icon fas fa-drafting-compass"></i>
                <p>Designer</p>
              </a>
            </li>
            @endcan
            @can('viewAny',App\Role::class)
            <li class="nav-item">
              <a href="{{ route('roles.index') }}" class="nav-link @hasSection('roles') active @endif">
                <i class="nav-icon fas fa-sitemap"></i>
                <p>Roles</p>
              </a>
            </li>
            @endcan
            @can('viewAny',App\Criteria::class)
            <li class="nav-item">
              <a href="{{ route('criterias.index') }}" class="nav-link @hasSection('criteria') active @endif">
                <i class="nav-icon fas fa-th"></i>
                <p>Criteria</p>
              </a>
            </li>
            @endcan
            @can('viewAny',App\Type::class)
            <li class="nav-item">
              <a href="{{ route('types.index') }}" class="nav-link @hasSection('types') active @endif">
                <i class="nav-icon fas fa-list"></i>
                <p>Types</p>
              </a>
            </li>
            @endcan
            @can('viewDelivery',App\Sale::class)
            <li class="nav-item">
              <a href="{{ route('delivers.index') }}" class="nav-link">
                <i class="nav-icon fas fa-truck"></i>
                <p>Delivery</p>
              </a>
            </li>
            @endcan
            @can('viewReceipt',App\Purchase::class)
            <li class="nav-item">
              <a href="{{ route('receipts.index') }}" class="nav-link">
                <i class="nav-icon fas fa-boxes"></i>
                <p>Receipt</p>
              </a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Simple Link
                  <span class="right badge badge-danger">New</span>
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="min-height: 1185px;">
      <div class="m-3">
        <!-- Content Header (Page header) -->
        <div class="">
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0 text-dark">@yield('title')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    @yield('breadcrumb')
                  </ol>
                </div><!-- /.col -->
              </div><!-- /.row -->
            </div><!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->
        </div>
        <!-- Main content -->
        <div class="card">
          <div class="card-body">
            <div class="content">
              <div class="">
                @yield('content')
              </div>
            </div>
          </div>
        </div>
        <!-- /.content -->
      </div>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright © 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
    <div id="sidebar-overlay"></div>
  </div>
  <!-- ./wrapper -->

  @yield('script')
  </body>
</html>
