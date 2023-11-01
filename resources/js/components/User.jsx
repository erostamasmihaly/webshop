import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import { getFetch, setFetch } from '../helper_react';

const RenderUser = () => {

    // Definiálás
    const [user, setUser] = useState([]);

    // Elemek lekérdezése
    useEffect(() => {
        getFetch('/api/user', setUser);
    }, []);

    console.log(user);
    
    /*const forceChange = () => {
        [...document.querySelectorAll("form input")].map(element => {
            const name = element.name;
            const value = element.value;
            setInputs(values => ({...values, [name]: value}));
        })
    }

    const [inputs, setInputs] = useState(user);

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}));
    }

    const handleSubmit = (event) => {
        event.preventDefault();
        forceChange();
        console.log(inputs);
    } */

    // Visszatérés a táblázattal
    return (
        <form onSubmit={handleSubmit}>
            <input type="hidden" name="id" defaultValue={user.id || 0} onChange={handleChange}/>
            <div className="row mb-2">
                <div className="col-sm-3">Felhasználói név</div>
                <div className="col-sm-9">
                    <input type="text" className="form-control" name="name" defaultValue={user.name || ''} onChange={handleChange}/>
                </div>
            </div>
            <div className="row mb-2">
                <div className="col-sm-3">Vezetéknév</div>
                <div className="col-sm-9">
                    <input type="text" className="form-control" name="surname" defaultValue={user.surname || ''} onChange={handleChange}/>
                </div>
            </div>
            <div className="row mb-2">
                <div className="col-sm-3">Keresztnév</div>
                <div className="col-sm-9">
                    <input type="text" className="form-control" name="forename" defaultValue={user.forename || ''} onChange={handleChange}/>
                </div>
            </div>
            <div className="row mb-2">
                <div className="col-sm-3">Ország</div>
                <div className="col-sm-9">
                    <input type="text" className="form-control" name="country" defaultValue={user.country || ''} onChange={handleChange}/>
                </div>
            </div>
            <div className="row mb-2">
                <div className="col-sm-3">Területi egység</div>
                <div className="col-sm-9">
                    <input type="text" className="form-control" name="state" defaultValue={user.state || ''} onChange={handleChange}/>
                </div>
            </div>
            <div className="row mb-2">
                <div className="col-sm-3">Irányítószám</div>
                <div className="col-sm-9">
                    <input type="text" className="form-control" name="zip" defaultValue={user.zip || ''} onChange={handleChange}/>
                </div>
            </div>
            <div className="row mb-2">
                <div className="col-sm-3">Település</div>
                <div className="col-sm-9">
                    <input type="text" className="form-control" name="city" defaultValue={user.city || ''} onChange={handleChange}/>
                </div>
            </div>
            <div className="row mb-2">
                <div className="col-sm-3">Utca, házszám...</div>
                <div className="col-sm-9">
                    <input type="text" className="form-control" name="address" defaultValue={user.address || ''} onChange={handleChange}/>
                </div>
            </div>  
            <button className="btn btn-primary">Mentés</button>
        </form> 
    );

};

const RenderAnswer = (data) => {

    // Definiálás
    const [response, setResponse] = useState([]);

    useEffect(() => {
        setFetch("/api/user", data, setResponse)
    }, []);

    if (response.OK==1) {
        return (
            <div className="alert alert-success" role="alert">
                Sikeres művelet!
            </div>
        )
    } else {
        return (
            <div className="alert alert-danger" role="alert">
                <ul>
                    {response.data.errors.map((item,index) => (
                        <li key={index}>{item}</li>
                    ))}
                </ul>
            </div>
        )
    }
}

// Tartalom
function User() {
    return (
        <div>
            <h1>Felhasználó adatai</h1>
            <RenderUser/>
        </div>
    );
}

// Tartalom betöltése
export default User;

if (document.getElementById('user')) {
    const Index = ReactDOM.createRoot(document.getElementById("user"));
    Index.render(
        <React.StrictMode>
            <User/>
        </React.StrictMode>
    )
}