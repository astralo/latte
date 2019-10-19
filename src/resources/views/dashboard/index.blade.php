@extends('dashboard.layout.default')

@section('content')
  <div class="row">
    <div class="col">

      <form method="POST" action="{{ route('dashboard.parse') }}">
        @csrf

        <div class="form-group">
          <textarea class="form-control" name="names" id="names" cols="30" rows="10"></textarea>
        </div>

        <button type="submit">Process</button>
      </form>

    </div>
  </div>
@endsection
