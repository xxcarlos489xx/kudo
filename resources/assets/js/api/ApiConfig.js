import axios from "axios";
const baseUrl = '/';

export default axios.create({
    baseUrl,
    headers: {
        // 'X-Requested-With' : 'XMLHttpRequest'
    }
})