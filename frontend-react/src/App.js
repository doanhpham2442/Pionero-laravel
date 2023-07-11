import React from "react";
import "./App.css";

import { BrowserRouter as Router, Route, Routes } from "react-router-dom";

import Home from "./Component/Home";
import Users from "./Component/User/Users";
import Show from "./Component/User/Show";
import Store from "./Component/User/Store";
import Edit from "./Component/User/Edit";


function App() {
    return (
        <div className="App">
            <Router>
                <Routes>
                    <Route exact path="/" element={<Home />} />
                    <Route exact path="/users" element={<Users />} />
                    <Route exact path="/users/:id" element={<Show />} />
                    <Route exact path="/users/store" element={<Store />} />
                    <Route exact path="/users/edit/:id" element={<Edit />} />
                </Routes>
            </Router>
        </div>
    );
}

export default App;
