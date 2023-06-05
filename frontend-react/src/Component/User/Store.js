import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import Validator from "../../utils/validator";
function Store() {
    const [message_error, setMessageError] = useState("");
    const [message_success, setMessageSuccess] = useState("");
    const navigate = useNavigate();

    const [txtname, setName] = useState("");
    const [txtemail, setEmail] = useState("");
    const [txtphone, setPhone] = useState("");
    const [txtpassword, setPassword] = useState("");

    const uploadUser = async () => {
        try {
            const formData = new FormData();
            formData.append("name", txtname);
            formData.append("email", txtemail);
            formData.append("phone", txtphone);
            formData.append("password", txtpassword);

            const response = await axios.post("http://pionero-laravel/api/users", formData, {
                headers: { "Content-Type": "multipart/form-data" },
            });
            console.log(response);
            setMessageSuccess(response.data.message); //"message": "User successfully created."
            setTimeout(() => {
                navigate("/users");
            }, 2000);
        } catch (error) {
            if (error.response) {
                // Lỗi từ phía API (có response từ server)
                console.log(error.response.data.errors);
                setMessageError("Error: " + error.response.data.errors.email);
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

    const [errors, setErrors] = useState({});
    const rules = [
        {
            field: "name",
            method: "isEmpty",
            validWhen: false,
            message: "Bạn chưa điền trường Name.",
        },
        {
            field: "email",
            method: "isEmpty",
            validWhen: false,
            message: "Bạn chưa điền trường Email.",
        },
        {
            field: "phone",
            method: "isEmpty",
            validWhen: false,
            message: "Bạn chưa điền trường Phone.",
        },
    ];
    const validator = new Validator(rules);
    const handleSubmit = async (e) => {
        e.preventDefault();
        const validationErrors = validator.validate({ name: txtname, email: txtemail, phone: txtphone });
        setErrors(validationErrors);
        if (Object.keys(validationErrors).length === 0) {
            await uploadUser();
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
