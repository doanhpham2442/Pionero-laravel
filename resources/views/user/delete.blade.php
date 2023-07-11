<div class="container">
    <div class="row">
        <div class="col-12">
            <h2 class="heading-2">
                Xóa thông tin: {{$user->name}}
            </h2>
        </div>
        <div class="col-12">
            <form action="" method="post" class="row">
            @csrf
                <div class="form-group col-6">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name"  placeholder="Name" value = "{{isset($user->name) ? $user->name : ''}}">
                </div>
                <div class="form-group col-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email"  placeholder="Enter email" value = "{{isset($user->email) ? $user->email : ''}}">
                </div>
                <div class="form-group col-6">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="phone"  placeholder="Enter phone" value = "{{isset($user->phone) ? $user->phone : ''}}">
                </div>
                <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary">Xóa thông tin</button>
                </div>
            </form>
        </div>
    </div>
</div>