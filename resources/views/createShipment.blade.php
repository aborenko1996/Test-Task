@extends('layouts.app')
@section('title', (isset($data) ? 'Edit' : 'Create') .  ' Shipment')
@section('content')
@if(isset($data['error']) && $data['error'])
<h1 class="text-center text-danger">{{$data['message']}}</h1>
@else
@if(!isset($data))
           <h1 class="text-center">Create Shipment</h1>
           <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">
                <form id="createShipmentForm" method="post" class="form-horizontal">
                        <div class="form-group">
                                <label class="control-label" for="id">ID</label>
                                <input name="id" required="required" min="1" type="number" class="form-control" placeholder="Enter ID">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <input name="name" required="required" type="text" class="form-control required" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <a href="{{url()->previous()}}" class="btn btn-primary">< Back</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                </form>
            </div>
@else
        <h1 class="text-center">Edit Shipment with ID {{$data['id']}}</h1>
            <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">
                <form id="createShipmentForm" method="post" class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <input name="name" required="required" value="{{$data['name']}}" type="text" class="form-control required" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <a href="{{url()->previous()}}" class="btn btn-primary">< Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                </form>
            </div>   
@endif
    @endsection
    @section('scripts')
    @if(!isset($data))
        <script>$("#createShipmentForm").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: '{{url('shipment/create')}}',
                method: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                data: {'id': $("input[name='id']").val(), 'name': $("input[name='name']").val()}
            }).then(function(response){
                if(response.expired){
                    alert('Token Expired');
                    location.reload();
                }
                if(response.error){
                    alert(response.message);
                }else{
                    alert("Shipment successfully created");
                    window.location = "{{url('/shipment/list')}}";
                }
            });
        })
        </script>
    @else
    <script>$("#createShipmentForm").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{url('shipment/' . $data['id'])}}",
                method: 'put',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                data: {'id': {{$data['id']}}, 'name': $("input[name='name']").val()}
            }).then(function(response){
                console.log(response);
                if(response.expired){
                    alert('Token Expired');
                    location.reload();
                }else{
                    if(response.error){
                        alert(response.message);
                    }else{
                        alert("Shipment successfully updated");
                        window.location = "{{url('/shipment/list')}}";
                    }
                }
            });
        })
        </script>
    @endif
    @endif
    @endsection