import React, { useState, useEffect } from "react";

import { Link } from "react-router-dom";
import axios from "axios";

function Users() {
    const [user, setUser] = useState([]);

    useEffect(() => {
        const getUser = () => {
            fetch("http://pionero-laravel/api/users")
                .then((res) => {
                    return res.json();
                })
                .then((response) => {
                    setUser(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        };
        getUser();
    }, []);

    const fetchUsers = () => {
        fetch("http://pionero-laravel/api/users")
            .then((res) => res.json())
            .then((response) => {
                console.log(response.data);
                setUser(response.data);
            })
            .catch((error) => {
                console.log(error);
            });
    };

    const deleteUser = (id) => {
        axios
            .delete("http://pionero-laravel/api/users/" + id)
            .then(function (response) {
                console.log(response.data);
                alert("Đã xóa User khỏi danh sách!");
                fetchUsers();
            })
            .catch(function (error) {
                console.log(error);
            });
    };

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
