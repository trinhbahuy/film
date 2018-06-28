<div class="side-bar col-md-3">
    <div class="left-side">
        <h3 class="shopf-sear-headits-sear-head">
       		Xin chào, </span> {!! auth()->user()->name !!}</h2>
       	</h3>
        <ul class="user_sidebar_menu">
            @include('users._menu')
        </ul>
    </div>
</div>