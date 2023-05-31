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
                <tr>
                    <th scope="row">{{$users['id']}}</th>
                    <td>{{$users['name']}}</td>
                    <td>{{$users['email']}}</td>
                    <td>{{$users['phone']}}</td>
                    <td>
                        <button type="button" class="btn btn-danger">Xóa</button>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>