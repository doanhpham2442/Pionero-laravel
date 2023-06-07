import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import Validator from "../../Utils/Validator";
import Rule from "../../Utils/Rules";
import Path from "../../Path/Path-api";
import axios from "../../Utils/Axios";

function Store() {
    const [message_error, setMessageError] = useState("");
    const [message_success, setMessageSuccess] = useState("");
    const navigate = useNavigate();

    const [txtname, setName] = useState("");
    const [txtemail, setEmail] = useState("");
    const [txtphone, setPhone] = useState("");
    const [txtpassword, setPassword] = useState("");

    const [errors, setErrors] = useState({});
    const validator = new Validator(Rule);
    const handleSubmit = async (e) => {
        e.preventDefault();
        const validationErrors = validator.validate({ name: txtname, email: txtemail, phone: txtphone });
        setErrors(validationErrors);
        if (Object.keys(validationErrors).length === 0) {
            await uploadUser();
        }
    };

    const uploadUser = async () => {
        try {
            const formData = new FormData();
            formData.append("name", txtname);
            formData.append("email", txtemail);
            formData.append("phone", txtphone);
            formData.append("password", txtpassword);

            const response = await axios({
                method: "post",
                url: Path.USER_PATH,
                data: formData,
                headers: { "Content-Type": "multipart/form-data" },
            });
            console.log(response);
            setMessageSuccess(response.data.message);
            setTimeout(() => {
                navigate("/users");
            }, 2000);
        } catch (error) {
            if (error.response) {
                // Lỗi từ phía API (có response từ server)
                console.log(error.response.data.errors);
                if (error.response.data.errors && typeof error.response.data.errors === 'object') {
                    const errorKeys = Object.keys(error.response.data.errors);
                    errorKeys.forEach((key) => {
                        setMessageError("Error: " + error.response.data.errors[key]);
                    });
                }
            } else if (error.request) {
                // Lỗi không nhận được phản hồi từ server
                console.log(error.request);
                setMessageError("Error: No response from server.");
            } else {
                // Lỗi xảy ra trong quá trình gửi request
                console.log(error);
                setMessageError("Error: " + error.message);
            }
        }
    };

    return (
        <React.Fragment>
            <div className="container">
                <div className="row">
                    <div className="col-12">
                        <h2 className="heading-2">Thêm User mới</h2>
                        {(message_error || message_success) && (
                            <div className={`alert alert-${message_error ? "danger" : "success"}`}>
                                {message_error ? message_error : message_success}
                            </div>
                        )}
                    </div>
                    <div className="col-12">
                        <form onSubmit={handleSubmit} className="row">
                            <div className="form-group col-6">
                                <label>Name</label>
                                <input type="text" className="form-control" onChange={(e) => setName(e.target.value)} placeholder="Name" />
                                {errors.name && (
                                    <div className="validation" style={{ display: "block" }}>{errors.name}</div>
                                )}
                            </div>
                            <div className="form-group col-6">
                                <label>Email</label>
                                <input type="email" className="form-control" onChange={(e) => setEmail(e.target.value)} placeholder="Enter email" />
                                {errors.email && (
                                    <div className="validation" style={{ display: "block" }}>{errors.email}</div>
                                )}
                            </div>
                            <div className="form-group col-6">
                                <label>Phone</label>
                                <input type="text" className="form-control" onChange={(e) => setPhone(e.target.value)} placeholder="Enter phone" />
                                {errors.phone && (
                                    <div className="validation" style={{ display: "block" }}>{errors.phone}</div>
                                )}
                            </div>
                            <div className="form-group col-6">
                                <label>Password</label>
                                <input type="password" className="form-control" onChange={(e) => setPassword(e.target.value)} placeholder="Password" />
                            </div>
                            <div className="form-group col-12">
                                <button type="submit" className="btn btn-primary">
                                    Lưu thông tin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
}
export default Store;
