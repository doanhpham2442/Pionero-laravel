<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="heading-2">
                Thông tin chi tiết: {{$users->name}}
            </h2>
        </div>
        <div class="col-12">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Id</th>
                <th scope="col">Tên</th>
                <th scope="col">Email</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">{{$users->id}}</th>
                    <td>{{$users->name}}</td>
                    <td>{{$users->email}}</td>
                    <td>{{$users->phone}}</td>
                    <td>
                        <a href="{{url('users/edit/'.$users->id.'')}}" class="btn btn-warning" >Sửa</a>
                        <a href="{{url('users/delete/'.$users->id.'')}}" class="btn btn-danger" >Xóa</a>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>