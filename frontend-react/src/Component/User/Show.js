import React, { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import Path from "../../Path/Path-api";
import axios from "../../Utils/Axios";

function Show() {
    const navigate = useNavigate();
    const { id } = useParams();
    const [message_error, setMessageError] = useState("");
    const [user, setUser] = useState([]);

    const getUser = async (id) => {
        try {
            const response = await axios({
                method: "get",
                url: Path.USER_DETAIL_PATH(id),
            });
            console.log(response.data);
            setUser(response.data.data);
        } catch (error) {
            console.log(error.response.data);
            setMessageError("Error: " + error.response.data.message);
            setTimeout(() => {
                navigate("/users");
            }, 1000);
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
        getUser(id);
    }, []);

    return (
        <React.Fragment>
            <div className="container container_overflow">
                <div className="row">
                    <div className="col-12">
                        <h2 className="heading-2">Thông tin chi tiết: {user.name}</h2>
                        {message_error && (
                            <div className="box-body">
                                <div className="alert alert-danger">{message_error}</div>
                            </div>
                        )}
                    </div>
                    <div className="col-12">
                        <p className="text-danger"> </p>
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
                                {Object.keys(user).length != 0 ? (
                                    <tr>
                                        <td>{user.id} </td>
                                        <td>{user.name} </td>
                                        <td>{user.email} </td>
                                        <td>{user.phone}</td>
                                        <td>
                                            <a href={"/users/edit/" + user.id} className="btn btn-warning">Sửa</a>
                                            <button onClick={() => deleteUser(user.id)} className="btn btn-danger">Xóa</button>
                                        </td>
                                    </tr>
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
export default Show;
