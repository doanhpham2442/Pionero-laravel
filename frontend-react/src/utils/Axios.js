import axios from "axios";
import Path from "../Path/Path-api";

const instance = axios.create({
    baseURL: Path.USER_PATH,
    timeout: 3000,
    headers: { 'X-Custom-Header': 'foobar' }
});

export default instance;