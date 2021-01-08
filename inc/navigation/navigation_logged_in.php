        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm navbar navbar-light bg-light">
          <!-- New -->

          <a href="<?php echo $url; ?>/page/dashboard" class="navbar-brand col-md-3">Logo</a>

          <!--
          <form class="form-inline col-md-4 center-block">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          </form>
        -->

        <div class="input-group col-md-3 center-block">
          <input type="text" class="form-control" placeholder="Durchsuchen..." style="background:#f6f7f9;">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="button" style="background:#fe7f2e;color:#fff;border-radius:6px;border:none;">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
          <!-- New END -->

            <div class="container cold-md-6">
              <!--
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>-->
                <!--
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>-->

                <div class="navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
<?php
 					if($myuserid == NULL) { 
?>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Register</a>
                            </li>
<?php
				} else {
?>
                          <li style="font-size:30px;padding-left:3px;padding-right:3px;">
                            <a href="#"><i class="fas fa-envelope" ></i></a>
                          </li>
                          <li style="font-size:30px;padding-left:3px;padding-right:3px;">
                            <a href="#"><i class="fas fa-bell" ></i></a>
                          </li>
                          <li style="font-size:30px;padding-left:3px;padding-right:3px;">
                            <a href="#"><i class="fas fa-cog" ></i></a>
                          </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre onclick="$( '.dropdown-menu' ).toggle();">
                                    <img alt="img" heigt="30" width="30" style="border-radius:100%;" src="https://dummyimage.com/100x100/7b4eca/fff.png&text=MP"><!--{{ Auth::user()->name }}-->
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo $url; ?>/pages/logout">Logout</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        <!--@csrf-->
                                    </form>
                                </div>
                            </li>
<?php
					}
?>
                    </ul>
                </div>
            </div>
        </nav>