@if(!Session::has('auth')) 
    <script>location.href = '/login'; </script>    
@endif 

<div class="navbar">
    <div class="navbar-inner">
    <div class="main-title">Kunsthalle Bremen - CMS</div>
        @if(Session::has('auth')) 
        	<!-- <div style="width:270px;background:lightblue;color:#222; padding:3px 10px; text-align:center; position:absolute;left:700px;top:10px;">You are logged in as admin </div> -->
	        <a href="{{ URL::to('logout') }}" class="lnk" style="margin-top:10px;float:right;">Ausloggen</a>
        @endif
    </div>
</div>