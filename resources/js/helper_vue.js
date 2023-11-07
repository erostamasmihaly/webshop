import axios from "axios";

export const request = async (method, url, data, is_multiform = false) => {
    const token = localStorage.getItem('USER_TOKEN')
    if (token !== undefined || token !== "") {
        let headers = null;
        if (is_multiform) {
            headers = {
                headers: {
                    Authorization: 'Bearer ' + token,
                    'Content-Type': 'multipart/form-data'
                }
            }
        } else {
            headers = {
                headers: {
                    Authorization: 'Bearer ' + token
                }
            }
        }
        let response = null;
        switch (method) {
            case 'get':
                response = await axios.get(url, headers)
                break;
            case 'post':
                response = await axios.post(url, data, headers)
                break;
            case 'put':
                response = await axios.put(url, data, headers)
                break;
            case 'delete':
                response = await axios.delete(url, headers)
                break;
            default:
                break;
        }
        return response
    }
    return false
}