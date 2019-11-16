<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ asset('img/Pintaar-Logo.jpg') }}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <div><i class="fa fa-circle text-success"></i> Super Administrator</div>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li>
        <a href="{{ route('admin.dashboard.home') }}">
          <i class="fa fa-th"></i> <span>Home</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
      <li class="treeview menu-open">
        <a href="">
          <i class="fa fa-pie-chart"></i>
          <span>Charts</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.dashboard.chart.user') }}"><i class="fa fa-circle-o"></i>Total User Chart</a></li>
          <li><a href="{{ route('admin.dashboard.chart.revenue') }}"><i class="fa fa-circle-o"></i>Revenue Chart</a></li>
          <li><a href="{{ route('admin.dashboard.chart.checkout') }}"><i class="fa fa-circle-o"></i>Abandon Checkout Chart</a></li>
          <li><a href="{{ route('admin.dashboard.chart.order') }}"><i class="fa fa-circle-o"></i>Average Order Chart</a></li>
          <li><a href="{{ route('admin.dashboard.chart.transaction') }}"><i class="fa fa-circle-o"></i>Total Transaction Chart</a></li>
          <li><a href="{{ route('admin.dashboard.chart.paid') }}"><i class="fa fa-circle-o"></i>Paid User Chart</a></li>
        </ul>
      </li>
     </ul>
  </section>
  <!-- /.sidebar -->
</aside>
