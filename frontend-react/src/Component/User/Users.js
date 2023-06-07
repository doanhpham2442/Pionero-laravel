import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import Path from "../../Path/Path-api";
import axios from "../../Utils/Axios";

function Users() {
    const [user, setUser] = useState([]);

    const getUser = async () => {
        try {
          const response = await axios({
            method: "get",
            url: Path.USER_PATH,
          });
          console.log(response);
          setUser(response.data.data);
        } catch (error) {
          console.log(error.response.data);
        }
    };

    const deleteUser = async (id) => {
        try {
            const response = await axios({
                method: "delete",
                url: Path.USER_DETAIL_PATH(id),
            });
            console.log(response.data);
            alert("Đã xóa User khỏi danh sách!");
            getUser();
        } catch (error) {
            console.log(error.response.data);
        }
    };

    
    useEffect(() => {
        getUser();
    }, []);

    return (
        <React.Fragment>
            <div className="container container_overflow">
                <div className="row">
                    <div className="col-12">
                        <h2 className="heading-2">Danh sách User</h2>
                    </div>
                    <div className="col-12">
                        <a href="/users/store" title="" className="btn btn-success btn-add">
                            Thêm mới User
                        </a>
                        <table className="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col" width="300">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {user.length > 0 ? (
                                    user.map((item, index) => (
                                        <tr key={index}>
                                            <td>{item.id} </td>
                                            <td>{item.name} </td>
                                            <td>{item.email} </td>
                                            <td>{item.phone}</td>
                                            <td>
                                                <a href={"/users/" + item.id} className="btn btn-primary">Chi tiết</a>
                                                <a href={"/users/edit/" + item.id} className="btn btn-warning">Sửa</a>
                                                <button onClick={() => deleteUser(item.id)} className="btn btn-danger">Xóa</button>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="5">Không có User nào để hiển thị</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
}
export default Users;
