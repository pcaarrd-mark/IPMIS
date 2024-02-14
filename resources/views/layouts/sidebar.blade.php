<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
  
          <li class="nav-item {{ $data['nav']['bp202_menu'] }}">
            <a href="#" class="nav-link {{ $data['nav']['bp202'] }}">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                BP202
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              {{-- <li class="nav-item">
                <a href="{{ url('/program') }}" class="nav-link {{ $data['nav']['program'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Program</p>
                </a>
              </li> --}}
              <li class="nav-item">
                <a href="{{ url('/bp202/dashboard') }}" class="nav-link {{ $data['nav']['bp202_dashboard'] }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('/project') }}" class="nav-link {{ $data['nav']['project'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Proposal</p>
                </a>
              </li>
              @if(Auth::user()->usertype == 'System Administrator')
              <li class="nav-item">
                <a href="{{ url('/bp202/summary') }}" class="nav-link {{ $data['nav']['bp202summary'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Summary</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/bp202/priority') }}" class="nav-link {{ $data['nav']['bp202_priority'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prioritization</p>
                </a>
              </li>
              @else
              <li class="nav-item">
                <a href="{{ url('/project/priority') }}" class="nav-link {{ $data['nav']['bp202_priority'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Prioritization</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          {{-- <li class="nav-item {{ $data['nav']['bp206_menu'] }}">
            <a href="#" class="nav-link {{ $data['nav']['bp206'] }}">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                BP206
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/program') }}" class="nav-link {{ $data['nav']['program'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Program</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/bp206/project') }}" class="nav-link {{ $data['nav']['bp206_project'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Projects</p>
                </a>
              </li>
              @if(Auth::user()->usertype == 'System Administrator')
              <li class="nav-item">
                <a href="{{ url('/bp206/summary') }}" class="nav-link {{ $data['nav']['bp206_summary'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Summary</p>
                </a>
              </li>
              @endif
            </ul>
          </li> --}}

          {{-- <li class="nav-item {{ $data['nav']['bp207_menu'] }}">
            <a href="#" class="nav-link {{ $data['nav']['bp207'] }}">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                BP207
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/program') }}" class="nav-link {{ $data['nav']['program'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Program</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/bp207/project') }}" class="nav-link {{ $data['nav']['bp207_project'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Projects</p>
                </a>
              </li>
              @if(Auth::user()->usertype == 'System Administrator')
              <li class="nav-item">
                <a href="{{ url('/bp207/summary') }}" class="nav-link {{ $data['nav']['bp207_summary'] }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Summary</p>
                </a>
              </li>
              @endif
            </ul>
          </li> --}}

          {{-- <li class="nav-item {{ $data['nav']['osep_menu'] }}">
            <a href="#" class="nav-link {{ $data['nav']['osep'] }}">
              <i class="nav-icon fas fa-folder"></i>
              <p>
                PROPOSALS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <a href="{{ url('/osep/proposals') }}" class="nav-link {{ $data['nav']['osep_proposals'] }}">
                  <i class="far fa-folder-open  nav-icon"></i>
                  <p>List</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ url('/osep/dpmis') }}" class="nav-link {{ $data['nav']['osep_dpmis'] }}">
                  <i class="fas fa-inbox nav-icon"></i>
                  <p>FROM DPMIS</p>
                </a>
              </li>
              
            </ul>
          </li> --}}

          {{-- <li class="nav-item {{ $data['nav']['monitor_menu'] }}">
            <a href="#" class="nav-link {{ $data['nav']['monitor'] }}">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                MONITORING
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/osep/projects') }}" class="nav-link {{ $data['nav']['monitor_project'] }}">
                  <i class="far fa-folder-open  nav-icon"></i>
                  <p>Projects</p>
                </a>
              </li>
              
            </ul>
          </li> --}}

          <li class="nav-item {{ $data['nav']['settings_menu'] }}">
            <a href="#" class="nav-link {{ $data['nav']['settings'] }}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                SETTINGS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/settings/account') }}" class="nav-link {{ $data['nav']['settings_account'] }}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Accounts</p>
                </a>
              </li>
              
            </ul>
          </li>


          {{-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-folder-open"></i>
              <p>
                PROPOSALS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DPMIS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Report</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-desktop"></i>
              <p>
                MONITORING
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Equipment</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tech Trans</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Report</p>
                </a>
              </li>
            </ul>
          </li> --}}

        </ul>
      </nav>
      <!-- /.sidebar-menu -->