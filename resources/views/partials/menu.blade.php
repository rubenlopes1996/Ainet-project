<div class="pull-right">
    Welcome {{Auth::user()->name}},
    <form style="display:inline" action="/logout" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>
