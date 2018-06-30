@extends('layouts.app')
@section('title', 'View Item')
@section('content')
<h1 class="text-center">View Item with ID {{$item['id']}}</h1>
<hr/>
<a href="{{url('shipment')}}" class="btn btn-primary">< Back</a>
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
                <td class="text-center">{{$item['id']}}</td>
                <td class="text-center">{{$item['shipment_id']}}</td>
                <td class="text-center">{{$item['name']}}</td>
                <td class="text-center">{{$item['code']}}</td>
                <td class="text-center">{{$item['created_at']}}</td>
                <td class="text-center">{{$item['updated_at']}}</td>
                <td>
                    <a class="btn btn-primary" href="{{url('item/' . $item['id'] . '/edit')}}">Edit</a>
                    <a class="btn btn-danger" onclick="DeleteItem({{$item['id']}})">Delete</a>
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
            if(response.error){
                alert(response.message);
                if(response.expired) window.location = "{{url('login')}}";
            }else{
                alert("Item with ID " + id + " successfully deleted");
                window.location = "{{url('shipment')}}";
            }
        })
    }
    
    </script>
@endsection