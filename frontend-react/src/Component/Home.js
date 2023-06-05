import React, {  } from "react";
 
function Home()
{
    return(
        <React.Fragment>
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <h1>Bài tập sử dụng ReactJs và Laravel</h1>
                    </div>
                    <div className="col-md-12">
                        <a href={"/users"} className="">Đi đến danh sách Users</a>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
}
export default Home;