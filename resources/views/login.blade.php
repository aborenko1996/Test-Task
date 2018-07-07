    @extends('layouts.app')
    @section('title', 'Login')
    @section('content')
           <h1 class="text-center">Login</h1>
           <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">
                <form id="loginForm" method="post" action="{{url('auth')}}" class="form-horizontal">
                        <div class="form-group">
                                <label class="control-label" for="email">Email</label>
                                <input name="email" required="required" type="email" class="form-control" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Password</label>
                            <input name="password" required="required" type="password" class="form-control required" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                </form>
            </div>
    @endsection
    @section('scripts')
        <script>$("#loginForm").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: '{{url('login')}}',
                method: 'post',
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'email': $("input[name='email']").val(), 'password': $("input[name='password']").val(), '_token': $("input[name='_token']").val()}
            }).then(function(response){
                if(response.error){
                    alert(response.message);
                }else{
                    alert("Login Successful");
                    window.location = "{{url('/shipment/list')}}"
                }
            });
        })
        </script>
    @endsection
