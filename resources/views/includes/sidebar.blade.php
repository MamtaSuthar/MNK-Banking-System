<div class="col-md-3">
    <div class="card">
        <div class="card-header">User Navigation</div>
        <div class="list-group">

            <a href="{{ route('home') }}" class="list-group-item list-group-item-action">Dashboard</a>

            <a href="{{ route('transfer.index') }}" class="list-group-item list-group-item-action">Transfer</a>
         
             <a class="dropdown-item list-group-item list-group-item-action" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>