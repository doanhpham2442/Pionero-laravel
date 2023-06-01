<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="heading-2">
                {{($method == 'create') ? "Thêm mới User" : "Sửa thông tin: $user->name"}}
            </h2>
            @if ($errors->any())
            <div class="box-body">
               <div class="alert alert-danger">
                 @foreach ($errors->all() as $error)
                     <p>{{ $error }}</p>
                 @endforeach
               </div>
            </div><!-- /.box-body -->
            @endif
        </div>
        <div class="col-12">
            @php
                $url = ($method == 'create') ? url('users/store') : url('users/update/'.$user->id);
             @endphp

            <form action="{{ $url }}" method="post" class="row">
            @csrf
                <div class="form-group col-6">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ isset($user->name) ? $user->name : (old('name') ? old('name') : '') }}">
                </div>
                <div class="form-group col-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email"  placeholder="Enter email" value = "{{isset($user->email) ? $user->email : (old('email') ? old('email') : '')}}">
                </div>
                <div class="form-group col-6">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="phone"  placeholder="Enter phone" value = "{{isset($user->phone) ? $user->phone : (old('phone') ? old('phone') : '')}}">
                </div>
                <div class="form-group col-6">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password"  placeholder="Password" value = "{{isset($user->password) ? $user->password : ''}}">
                </div>
                <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                </div>
                
            </form>
        </div>
    </div>
</div>