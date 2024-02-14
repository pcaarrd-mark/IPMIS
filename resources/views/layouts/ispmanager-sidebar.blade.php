<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

               <li class="nav-item">
                <a href="{{url('bp202/dashboard')}}" class="nav-link {{ $data['nav']['ispmanager_dashboard'] }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
               </li>
               <li class="nav-header">PROPOSAL</li>
               <li class="nav-item">
                 <a href="{{url('/project')}}" class="nav-link {{ $data['nav']['osep_division_program'] }}">
                   <i class="nav-icon far fa-folder"></i>
                   <p>
                     Projects
                   </p>
                 </a>
               </li>
               {{-- <li class="nav-item">
                  <a href="{{url('/project/division')}}" class="nav-link {{ $data['nav']['osep_division_project'] }}">
                    <i class="nav-icon far fa-folder"></i>
                    <p>
                      LIST
                    </p>
                  </a>
               </li>

               <li class="nav-header">MONITORING</li>
               <li class="nav-item">
                  <a href="{{url('/osep/project')}}" class="nav-link {{ $data['nav']['monitor_project'] }}">
                    <i class="nav-icon far fa-folder"></i>
                    <p>
                      LIST
                    </p>
                  </a>
               </li> --}}

               
               <li class="nav-header">SETTINGS</li>
               <li class="nav-item">
               <a href="../calendar.html" class="nav-link">
                <i class="nav-icon far fa-user"></i>
                <p>
                  Account
                </p>
              </a>
      </nav>
      <!-- /.sidebar-menu -->