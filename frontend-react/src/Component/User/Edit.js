import React, { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import Validator from "../../Utils/Validator";
import Rules from "../../Utils/Rules";
import Path from "../../Path/Path-api";
import axios from "../../Utils/Axios";

function Edit() {
    const navigate = useNavigate();
    const { id } = useParams();
    const [message_error, setMessageError] = useState("");
    const [message_success, setMessageSuccess] = useState("");
    const [inputs, setInputs] = useState([]);

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs((values) => ({ ...values, [name]: value }));
    };

    const getUser = async (id) => {
        try {
            const response = await axios({
                method: "get",
                url: Path.USER_DETAIL_PATH(id),
            });
            console.log(response.data);
            setInputs(response.data.data);
        } catch (error) {
            console.log(error.response.data);
            setMessageError("Error: " + error.response.data.message);
            setTimeout(() => {
                navigate("/users");
            }, 1000);
        }
    };
    
    const [errors, setErrors] = useState({});
    const validator = new Validator(Rules);
    const handleSubmit = async (e) => {
        e.preventDefault();
        const validationErrors = validator.validate({ name: inputs.name, email: inputs.email, phone: inputs.phone });
        setErrors(validationErrors);
        if (Object.keys(validationErrors).length === 0) {
            await uploadUser();
        }
    };

    const uploadUser = async () => {
        try {
            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append("name", inputs.name);
            formData.append("email", inputs.email);
            formData.append("phone", inputs.phone);
            formData.append("password", inputs.password);

            const response = await axios({
                method: "post",
                url: Path.USER_DETAIL_PATH(id),
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

    useEffect(() => {
        getUser(id);
    }, []);

    return (
        <React.Fragment>
            <div className="container">
                <div className="row">
                    <div className="col-12">
                        <h2 className="heading-2">Sửa thông tin: {inputs.name}</h2>
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
                                <input type="text" value={inputs.name} className="form-control" name="name" onChange={handleChange} />
                                {errors.name && (
                                    <div className="validation" style={{ display: "block" }}>{errors.name}</div>
                                )}
                            </div>
                            <div className="form-group col-6">
                                <label>Email</label>
                                <input type="text" value={inputs.email} className="form-control" name="email" onChange={handleChange} />
                                {errors.email && (
                                    <div className="validation" style={{ display: "block" }}>{errors.email}</div>
                                )}
                            </div>
                            <div className="form-group col-6">
                                <label>Phone</label>
                                <input type="text" value={inputs.phone} className="form-control" name="phone" onChange={handleChange} />
                                {errors.phone && (
                                    <div className="validation" style={{ display: "block" }}>{errors.phone}</div>
                                )}
                            </div>
                            <div className="form-group col-6">
                                <label>Password</label>
                                <input type="text" value={inputs.password} className="form-control" name="password" onChange={handleChange} />
                            </div>
                            <div className="form-group col-12">
                                <button type="submit" className="btn btn-primary">Cập nhật thông tin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
}
export default Edit;
