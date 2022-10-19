@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if(session('not success'))
    <div class="alert alert-danger">
        {{session('not success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert aler-danger">
        {{session('error')}}
    </div>
@endif
