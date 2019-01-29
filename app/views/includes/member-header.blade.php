<div class="navbar">
    <div class="navbar-inner">
    <div class="main-title" style="margin-top:10px;">Kunsthalle Bremen - CMS</div>
        @if(Session::has('auth')) 
	        <a href="{{ URL::to('logout') }}" class="lnk" style="margin-top:10px;float:right;">Logout</a>
        @endif
    </div>
</div>