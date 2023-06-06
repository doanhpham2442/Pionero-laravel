<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="heading-2">
                Thông tin tất cả User
            </h2>
        </div>
        <div class="col-12">
            <a href="{{url('users/create')}}" title="" class="btn btn-success btn-add" >Thêm mới User</a>
            <table class="table table-striped">
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
                @if(isset($users) && count($users))
                    @foreach ($users as $key => $val)
                        <tr>
                            <th scope="row">{{$val->id}}</th>
                            <td>{{$val->name}}</td>
                            <td>{{$val->email}}</td>
                            <td>{{$val->phone}}</td>
                            <td>
                                <a href="{{url('users/'.$val->id)}}" class="btn btn-primary">Chi tiết</a>
                                <a href="{{url('users/edit/'.$val->id)}}" class="btn btn-warning">Sửa</a>
                                <a href="{{url('users/delete/'.$val->id)}}" class="btn btn-danger">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">Không có bản ghi nào!</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>