<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="heading-2">
                Thông tin chi tiết: {{$user->name}}
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
                    <th scope="row">{{$user->id}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>
                        <a href="{{url('users/edit/'.$user->id.'')}}" class="btn btn-warning" >Sửa</a>
                        <a href="{{url('users/delete/'.$user->id.'')}}" class="btn btn-danger" >Xóa</a>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>