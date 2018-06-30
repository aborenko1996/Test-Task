@extends('layouts.app')
@section('title', (isset($item) ? 'Edit' : 'Create') .  ' Item')
@section('content')
@if(!isset($item))
           <h1 class="text-center">Create Item</h1>
           <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">
                <form id="createShipmentForm" method="post" class="form-horizontal">
                        <div class="form-group">
                                <label class="control-label" for="id">ID</label>
                                <input name="id" required="required" pattern= "([1-9])([0-9])*" type="text" class="form-control" placeholder="Enter ID">
                        </div>
                        <div class="form-group">
                                <label class="control-label" for="shipment">Shipment</label>
                                <select class="form-control" id="shipment">
                                   @foreach ($shipments as $shipment)
                                    <option value="{{$shipment['id']}}">{{$shipment['name']}}</option>
                                   @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <input name="name" required="required" type="text" class="form-control required" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="code">Code</label>
                            <input name="code" required="required" pattern= "([0-9])+" type="text" class="form-control required" placeholder="Enter code">
                        </div>
                        <div class="form-group">
                            <a href="{{url()->previous()}}" class="btn btn-primary">< Back</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                </form>
            </div>
@else
        <h1 class="text-center">Edit Item with ID {{$item['id']}}</h1>
            <div class="col-lg-offset-3 col-lg-6 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-3 col-xs-6">
                <form id="createShipmentForm" method="post" class="form-horizontal">
                        <div class="form-group">
                                <label class="control-label" for="shipment">Shipment</label>
                                <select class="form-control" id="shipment">
                                   @foreach ($shipments as $shipment)
                                    <option @if($shipment['id'] == $item['shipment_id']) selected @endif value="{{$shipment['id']}}">{{$shipment['name']}}</option>
                                   @endforeach
                                </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Name</label>
                            <input value="{{$item['name']}}" name="name" required="required" type="text" class="form-control required" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="code">Code</label>
                        <input name="code" value="{{$item['code']}}" required="required" pattern= "([0-9])+" type="text" class="form-control required" placeholder="Enter code">
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
    @if(!isset($item))
        <script>$("#createShipmentForm").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: '{{url('item/create')}}',
                method: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                data: {'id': $("input[name='id']").val(), 'name': $("input[name='name']").val(), 'code': $("input[name='code']").val(), 'shipment_id':$("#shipment").val()}
            }).then(function(response){
                if(response.error){
                    alert(response.message);
                    if(response.expired) window.location = "{{url('login')}}";
                }else{
                    alert("Item successfully created");
                    console.log(response);
                    window.location = "{{url('/shipment')}}";
                }
            });
        })
        </script>
    @else
    <script>$("#createShipmentForm").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "{{url('item/' . $item['id'])}}",
                method: 'put',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                data: {'id': {{$item['id']}}, 'name': $("input[name='name']").val(), 'code': $("input[name='code']").val(), 'shipment_id':$("#shipment").val()}
            }).then(function(response){
                if(response.error){
                    alert(response.message);
                    if(response.expired) window.location = "{{url('login')}}";
                }else{
                    alert("Item successfully updated");
                    window.location = "{{url('/shipment')}}";
                }
            });
        })
        </script>
    @endif
    @endsection