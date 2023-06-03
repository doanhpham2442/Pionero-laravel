<div class="container">
    <div class="row">
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
                @foreach ($users as $key => $val)
                    <tr>
                        <th scope="row">{{$val['id']}}</th>
                        <td>{{$val['name']}}</td>
                        <td>{{$val['email']}}</td>
                        <td>{{$val['phone']}}</td>
                        <td>
                            <a href="{{$_SERVER['REQUEST_URI']}}/{{$val['id']}}" class="btn btn-warning" >Chi tiết</a>
                            <button type="button" class="btn btn-danger">Xóa</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>