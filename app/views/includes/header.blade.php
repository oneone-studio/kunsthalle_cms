@if(!Session::has('auth')) 
    <script>location.href = '/login'; </script>    
@endif 

<div class="navbar">
    <div class="navbar-inner">
    <div class="main-title">Kunsthalle Bremen - CMS</div>
        @if(Session::has('auth')) 
	        <a href="{{ URL::to('logout') }}" class="lnk" style="margin-top:10px;float:right;">Ausloggen</a>
        @endif
    </div>
</div>