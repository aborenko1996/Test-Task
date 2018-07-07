@extends('layouts.app')
@section('title', 'View Item')
@section('content')
@if(isset($data['error']) && $data['error'])
<h1 class="text-center text-danger">{{$data['message']}}</h1>
@else
<h1 class="text-center">View Item with ID {{$data['id']}}</h1>
<hr/>
<a href="{{url('shipment/list')}}" class="btn btn-primary">< Back</a>
<hr/>
<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Shipment ID</th>
            <th class="text-center">Name</th>
            <th class="text-center">Code</th>
            <th class="text-center">Created At</th>
            <th class="text-center">Updated At</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td class="text-center">{{$data['id']}}</td>
                <td class="text-center">{{$data['shipment_id']}}</td>
                <td class="text-center">{{$data['name']}}</td>
                <td class="text-center">{{$data['code']}}</td>
                <td class="text-center">{{$data['created_at']}}</td>
                <td class="text-center">{{$data['updated_at']}}</td>
                <td>
                    <a class="btn btn-primary" href="{{url('item/' . $data['id'] . '/edit')}}">Edit</a>
                    <a class="btn btn-danger" onclick="DeleteItem({{$data['id']}})">Delete</a>
                </td>
            </tr>
    </tbody>
</table>
@endsection
@section('scripts')
    <script>function DeleteItem(id){
        $.ajax({
            url: '{{url('item')}}' + '/' + id,
            method: 'delete',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).then(function(response){
            if(response.expired){
                alert('Token Expired');
                location.reload();
            }else{
                if(response.error){
                    alert(response.message);
                }else{
                    alert("Item with ID " + id + " successfully deleted");
                    window.location = "{{url('shipment/list')}}";
                }
            }
        })
    }
    
    </script>
@endif
@endsection