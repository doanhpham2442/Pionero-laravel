@php
    $uriModule = Request::segment(2);
    $uriMainModule = Request::segment(3);
@endphp
<nav class="pcoded-navbar">
   <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigatio-lavel">Navigation </div>
        <ul class="pcoded-item pcoded-left-item">
           <li class="pcoded-trigger">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                </a>
           </li>
           <li class="pcoded-hasmenu active  {{ ( $uriModule == 'post' ) ? 'pcoded-trigger'  : '' }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-sidebar"></i></span>
                    <span class="pcoded-mtext">QL Bài Viết</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ ( $uriMainModule == 'catalogue' ) ? 'active'  : '' }}">
                       <a href="{{ route('post.catalogue.index') }}">
                           <span class="pcoded-mtext">QL Nhóm Bài Viết</span>
                       </a>
                    </li>
                    <li class="{{ ( $uriMainModule == 'post' ) ? 'active'  : '' }}">
                       <a href="{{ route('post.catalogue.index') }}">
                           <span class="pcoded-mtext">QL Bài Viết</span>
                       </a>
                    </li>
                </ul>
           </li>
           <li class="pcoded-hasmenu {{ ( $uriModule == 'translate' || $uriModule == 'permission') ? 'pcoded-trigger'  : '' }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i></span>
                    <span class="pcoded-mtext">Cấu hình chung</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ ( $uriModule == 'translate' ) ? 'active'  : '' }}">
                       <a href="{{ route('translate.index') }}">
                           <span class="pcoded-mtext">QL Ngôn ngữ</span>
                       </a>
                    </li>
                    <li class="{{ ( $uriModule == 'permission' ) ? 'active'  : '' }}">
                       <a href="{{ route('permission.index') }}">
                           <span class="pcoded-mtext">QL Phân Quyền</span>
                       </a>
                    </li>
                </ul>
           </li>
           <li class="pcoded-hasmenu {{ ( $uriModule == 'user'  ) ? 'pcoded-trigger'  : '' }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-user"></i></span>
                    <span class="pcoded-mtext">QL Thành Viên</span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ ( $uriMainModule == 'catalogue' ) ? 'active'  : '' }}">
                       <a href="{{ route('user.catalogue.index') }}">
                           <span class="pcoded-mtext">QL Nhóm Thành Viên</span>
                       </a>
                    </li>
                    <li class="{{ ( $uriMainModule == 'user' ) ? 'active'  : '' }}">
                       <a href="{{ route('user.index') }}">
                           <span class="pcoded-mtext">QL Thành Viên</span>
                       </a>
                    </li>
                </ul>
           </li>
        </ul>
   </div>
</nav>
