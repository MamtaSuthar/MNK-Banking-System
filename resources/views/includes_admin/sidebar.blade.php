<div class="col-md-3">
    <div class="card">
        <div class="card-header">Admin Navigation</div>
        <div class="list-group">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action">Manage Users</a>
            <a href="{{ route('admin.accounts') }}" class="list-group-item list-group-item-action">Manage Accounts</a>
            {{-- <a href="{{ route('admin.transactions') }}" class="list-group-item list-group-item-action">Transactions</a> --}}
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