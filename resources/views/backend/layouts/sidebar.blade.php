<div class="sidebar" data-color="red" data-active-color="danger">
    <div class="logo">
        <router-link to="/admin" class="simple-text logo-mini">
            <div class="logo-image-small">
                <img src="../assets/img/logo-small.png">
            </div>
        </router-link>
        <router-link to="/admin" class="simple-text logo-normal">
            {{name()}}
        </router-link>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <router-link to="/admin" class="text-light">
                <li>
                    <a>
                        <i class="nc-icon nc-bank"></i>
                        Dashboard
                    </a>
                </li>
            </router-link>
            <router-link to="/admin/role" class="text-light">
                <li>
                    <a>
                        <i class="nc-icon nc-diamond"></i>
                        Roles
                    </a>
                </li>
            </router-link>
            <router-link to="/admin/users" class="text-light">
                <li>
                    <a>
                        <i class="nc-icon nc-single-02"></i>
                        Users
                    </a>
                </li>
            </router-link>


            <li class="active-pro">
                <a class="btn btn-primary" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="nc-icon nc-spaceship"></i>
                    <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>

    </div>
</div>