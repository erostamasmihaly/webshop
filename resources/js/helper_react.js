const token = localStorage.getItem('USER_TOKEN')
const headers = {
    headers: {
        Authorization: 'Bearer ' + token
    }
}

const getFetch = (url, func) => {

    fetch(url, headers)
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                func(data);
            })
            .catch((err) => {
                console.log(err.message);
            });
}

export { getFetch };